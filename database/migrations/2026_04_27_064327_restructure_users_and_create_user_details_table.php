<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration {
    public function up(): void {

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // STEP 1: users table mein columns add karo — jo nahi hain sirf unhe add karo
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role'))
                $table->enum('role', ['admin', 'student', 'teacher'])->default('student')->after('email');
            if (!Schema::hasColumn('users', 'registration_number'))
                $table->string('registration_number')->nullable()->unique()->after('role');
            if (!Schema::hasColumn('users', 'registration_date'))
                $table->string('registration_date')->nullable()->after('registration_number');
            if (!Schema::hasColumn('users', 'father_name'))
                $table->string('father_name')->nullable()->after('registration_date');
            if (!Schema::hasColumn('users', 'date_of_birth'))
                $table->date('date_of_birth')->nullable()->after('father_name');
            if (!Schema::hasColumn('users', 'mobile'))
                $table->string('mobile', 20)->nullable()->after('date_of_birth');
            if (!Schema::hasColumn('users', 'whatsapp'))
                $table->string('whatsapp', 20)->nullable()->after('mobile');
            if (!Schema::hasColumn('users', 'address'))
                $table->text('address')->nullable()->after('whatsapp');
            if (!Schema::hasColumn('users', 'gender'))
                $table->string('gender')->nullable()->after('address');
            if (!Schema::hasColumn('users', 'image'))
                $table->string('image')->nullable()->after('gender');
            if (!Schema::hasColumn('users', 'aadhaar_number'))
                $table->string('aadhaar_number')->nullable()->after('image');
            if (!Schema::hasColumn('users', 'aadhaar_card'))
                $table->string('aadhaar_card')->nullable()->after('aadhaar_number');
            if (!Schema::hasColumn('users', 'status'))
                $table->enum('status', ['active', 'inactive'])->default('active')->after('aadhaar_card');
        });

        // STEP 2: Existing users ko admin role do
        DB::table('users')->whereNull('role')->update(['role' => 'admin']);
        DB::table('users')->where('role', '')->update(['role' => 'admin']);

        // STEP 3: students data → users mein migrate karo
        $students = DB::table('students')->whereNull('deleted_at')->get();
        $studentIdMap = [];

        foreach ($students as $student) {
            $email = $student->email ?: ('student_' . $student->id . '@sumantech.local');
            $existingUser = DB::table('users')->where('email', $email)->first();

            if ($existingUser) {
                DB::table('users')->where('id', $existingUser->id)->update([
                    'role'                => 'student',
                    'registration_number' => $student->registration_number,
                    'registration_date'   => $student->registration_date,
                    'father_name'         => $student->father_name,
                    'date_of_birth'       => $student->date_of_birth,
                    'mobile'              => $student->mobile,
                    'whatsapp'            => $student->whatsapp,
                    'address'             => $student->address,
                    'gender'              => $student->gender,
                    'image'               => $student->image,
                    'aadhaar_number'      => $student->aadhaar_number,
                    'aadhaar_card'        => $student->aadhaar_card,
                    'status'              => $student->status,
                    'phone'               => $student->mobile,
                ]);
                $studentIdMap[$student->id] = $existingUser->id;
            } else {
                $userId = DB::table('users')->insertGetId([
                    'name'                => $student->name,
                    'email'               => $email,
                    'password'            => Hash::make($student->password ?? 'password123'),
                    'role'                => 'student',
                    'registration_number' => $student->registration_number,
                    'registration_date'   => $student->registration_date,
                    'father_name'         => $student->father_name,
                    'date_of_birth'       => $student->date_of_birth,
                    'mobile'              => $student->mobile,
                    'whatsapp'            => $student->whatsapp,
                    'address'             => $student->address,
                    'gender'              => $student->gender,
                    'image'               => $student->image,
                    'aadhaar_number'      => $student->aadhaar_number,
                    'aadhaar_card'        => $student->aadhaar_card,
                    'status'              => $student->status,
                    'phone'               => $student->mobile,
                    'is_active'           => $student->status === 'active' ? 1 : 0,
                    'created_at'          => $student->created_at,
                    'updated_at'          => $student->updated_at,
                ]);
                $studentIdMap[$student->id] = $userId;
            }
        }

        // STEP 4: student_courses foreign key drop karo
        try {
            Schema::table('student_courses', function (Blueprint $table) {
                $table->dropForeign(['student_id']);
            });
        } catch (\Exception $e) {
            // Already dropped
        }

        // STEP 5: student_courses update karo
        foreach ($studentIdMap as $oldStudentId => $newUserId) {
            DB::table('student_courses')
                ->where('student_id', $oldStudentId)
                ->update(['student_id' => $newUserId]);
        }

        // STEP 6: rename student_id → user_id
        if (Schema::hasColumn('student_courses', 'student_id')) {
            Schema::table('student_courses', function (Blueprint $table) {
                $table->renameColumn('student_id', 'user_id');
            });
        }

        // STEP 7: invoices update karo
        foreach ($studentIdMap as $oldStudentId => $newUserId) {
            DB::table('invoices')
                ->where('user_id', $oldStudentId)
                ->update(['user_id' => $newUserId]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    public function down(): void {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        if (Schema::hasColumn('student_courses', 'user_id')) {
            Schema::table('student_courses', function (Blueprint $table) {
                $table->renameColumn('user_id', 'student_id');
            });
        }

        Schema::table('users', function (Blueprint $table) {
            $cols = ['registration_number', 'registration_date', 'father_name',
                     'date_of_birth', 'mobile', 'whatsapp', 'address', 'gender',
                     'image', 'aadhaar_number', 'aadhaar_card', 'status'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
};