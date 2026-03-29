<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGoodLuckMessageRequest;
use App\Http\Requests\Admin\UpdateGoodLuckMessageRequest;
use App\Models\GoodLuckMessage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class GoodLuckMessageController extends Controller implements HasMiddleware
{
    public static function middleware(): array {
        return [new Middleware('auth')];
    }

    public function index() {
        $query = GoodLuckMessage::with('createdBy', 'updatedBy')->latest();
        if (request('search')) $query->where('title', 'like', '%' . request('search') . '%');
        return view('admin.good_luck_messages.index', ['messages' => $query->paginate(20)->withQueryString()]);
    }

    public function create() { return view('admin.good_luck_messages.create'); }

    public function store(StoreGoodLuckMessageRequest $request) {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        GoodLuckMessage::create($data);
        return redirect()->route('admin.good-luck-messages.index')->with('success', 'Message successfully added!');
    }

    public function edit(GoodLuckMessage $goodLuckMessage) { return view('admin.good_luck_messages.edit', compact('goodLuckMessage')); }

    public function update(UpdateGoodLuckMessageRequest $request, GoodLuckMessage $goodLuckMessage) {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        $goodLuckMessage->update($data);
        return redirect()->route('admin.good-luck-messages.index')->with('success', 'Message successfully updated!');
    }

    public function destroy(GoodLuckMessage $goodLuckMessage) {
        $goodLuckMessage->delete();
        return redirect()->route('admin.good-luck-messages.index')->with('success', 'Message deleted!');
    }
}
