<?php
namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\UserAchievement;
use App\Models\UserActivity;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PortalController extends Controller
{
    public function overview() {
        $user = Auth::user()->load('profile','achievements','activities');
        $this->logActivity('Viewed profile overview', 'profile_viewed');
        return view('portal.overview', compact('user'));
    }
    public function personal() {
        $user = Auth::user()->load('profile');
        return view('portal.personal', compact('user'));
    }
    public function savePersonal(Request $request) {
        $request->validate(['name'=>'required|string|max:255','phone'=>'nullable|string|max:15','gender'=>'nullable|in:male,female,other','dob'=>'nullable|date']);
        $user = Auth::user();
        $user->update(['name'=>$request->name,'phone'=>$request->phone]);
        $profileData = $request->only(['gender','dob','father_name','mother_name','alternate_mobile','state','district','block','pincode','panchayat','village','address']);
        if($request->hasFile('avatar')){$request->validate(['avatar'=>'image|max:2048']);if($user->profile&&$user->profile->avatar){Storage::disk('public')->delete($user->profile->avatar);}$profileData['avatar']=$request->file('avatar')->store('avatars','public');}
        UserProfile::updateOrCreate(['user_id'=>$user->id],$profileData);
        $this->logActivity('Updated personal details','profile_updated');
        return back()->with('success','Personal details saved successfully!');
    }
    public function education() {
        $user = Auth::user()->load('profile');
        return view('portal.education', compact('user'));
    }
    public function saveEducation(Request $request) {
        $data = $request->only(['highest_education','college','subject','pass_year','designation','department','school','employee_id','bio','facebook','twitter','instagram','linkedin','youtube']);
        UserProfile::updateOrCreate(['user_id'=>Auth::id()],$data);
        $this->logActivity('Updated education details','education_updated');
        return back()->with('success','Details saved successfully!');
    }
    public function achievements() {
        $user = Auth::user();
        $achievements = UserAchievement::where('user_id',$user->id)->latest()->get();
        return view('portal.achievements', compact('user','achievements'));
    }
    public function storeAchievement(Request $request) {
        $request->validate(['title'=>'required|string|max:255','achievement_type'=>'required|in:self,school,district','file'=>'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120']);
        $data = $request->only(['title','category','achievement_type','description','achievement_date']);
        $data['user_id'] = Auth::id();
        if($request->hasFile('file')){$data['file']=$request->file('file')->store('achievements','public');}
        UserAchievement::create($data);
        $this->logActivity('Added achievement: '.$request->title,'achievement_created');
        return back()->with('success','Achievement added successfully!');
    }
    public function deleteAchievement(UserAchievement $achievement) {
        if($achievement->user_id!==Auth::id()) abort(403);
        if($achievement->file) Storage::disk('public')->delete($achievement->file);
        $achievement->delete();
        return back()->with('success','Achievement deleted!');
    }
    public function security() {
        $user = Auth::user();
        return view('portal.security', compact('user'));
    }
    public function changePassword(Request $request) {
        $request->validate(['current_password'=>'required','password'=>'required|min:8|confirmed']);
        $user = Auth::user();
        if(!Hash::check($request->current_password,$user->password)){return back()->withErrors(['current_password'=>'Current password incorrect!']);}
        $user->update(['password'=>Hash::make($request->password)]);
        $this->logActivity('Changed password','password_changed');
        return back()->with('success','Password changed successfully!');
    }
    public function activity() {
        $user = Auth::user();
        $activities = UserActivity::where('user_id',$user->id)->latest()->paginate(20);
        return view('portal.activity', compact('user','activities'));
    }
    private function logActivity($description,$event,$subject=null) {
        try{UserActivity::create(['user_id'=>Auth::id(),'description'=>$description,'event'=>$event,'subject'=>$subject]);}catch(\Exception $e){}
    }
}
