<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('user_profiles', 'registration_number')) {
                $table->string('registration_number')->nullable()->unique()->after('user_id');
            }
            if (!Schema::hasColumn('user_profiles', 'registration_date')) {
                $table->date('registration_date')->nullable()->after('registration_number');
            }
            if (!Schema::hasColumn('user_profiles', 'mobile')) {
                $table->string('mobile', 20)->nullable()->after('alternate_mobile');
            }
            if (!Schema::hasColumn('user_profiles', 'whatsapp')) {
                $table->string('whatsapp', 20)->nullable()->after('mobile');
            }
            if (!Schema::hasColumn('user_profiles', 'class')) {
                $table->string('class')->nullable()->after('school');
            }
            if (!Schema::hasColumn('user_profiles', 'image')) {
                $table->string('image')->nullable()->after('avatar');
            }
            if (!Schema::hasColumn('user_profiles', 'aadhaar_number')) {
                $table->string('aadhaar_number')->nullable()->after('image');
            }
            if (!Schema::hasColumn('user_profiles', 'aadhaar_card')) {
                $table->string('aadhaar_card')->nullable()->after('aadhaar_number');
            }
            if (!Schema::hasColumn('user_profiles', 'status')) {
                $table->string('status', 20)->default('active')->after('aadhaar_card');
            }
        });

        $this->copyUserColumnsToProfiles();
        $studentIdMap = $this->copyStudentsToUsersAndProfiles();
        $this->moveStudentCourseForeignKey($studentIdMap);

        Schema::dropIfExists('students');
        $this->dropProfileColumnsFromUsers();
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'avatar')) $table->string('avatar')->nullable()->after('phone');
            if (!Schema::hasColumn('users', 'designation')) $table->string('designation')->nullable()->after('avatar');
            if (!Schema::hasColumn('users', 'department')) $table->string('department')->nullable()->after('designation');
            if (!Schema::hasColumn('users', 'about')) $table->text('about')->nullable()->after('department');
            if (!Schema::hasColumn('users', 'district')) $table->string('district')->nullable()->after('user_type');
            if (!Schema::hasColumn('users', 'school')) $table->string('school')->nullable()->after('district');
            if (!Schema::hasColumn('users', 'class')) $table->string('class')->nullable()->after('school');
            if (!Schema::hasColumn('users', 'registration_number')) $table->string('registration_number')->nullable()->unique()->after('role');
            if (!Schema::hasColumn('users', 'registration_date')) $table->date('registration_date')->nullable()->after('registration_number');
            if (!Schema::hasColumn('users', 'father_name')) $table->string('father_name')->nullable()->after('registration_date');
            if (!Schema::hasColumn('users', 'date_of_birth')) $table->date('date_of_birth')->nullable()->after('father_name');
            if (!Schema::hasColumn('users', 'mobile')) $table->string('mobile', 20)->nullable()->after('date_of_birth');
            if (!Schema::hasColumn('users', 'whatsapp')) $table->string('whatsapp', 20)->nullable()->after('mobile');
            if (!Schema::hasColumn('users', 'address')) $table->text('address')->nullable()->after('whatsapp');
            if (!Schema::hasColumn('users', 'gender')) $table->string('gender')->nullable()->after('address');
            if (!Schema::hasColumn('users', 'image')) $table->string('image')->nullable()->after('gender');
            if (!Schema::hasColumn('users', 'aadhaar_number')) $table->string('aadhaar_number')->nullable()->after('image');
            if (!Schema::hasColumn('users', 'aadhaar_card')) $table->string('aadhaar_card')->nullable()->after('aadhaar_number');
            if (!Schema::hasColumn('users', 'status')) $table->string('status', 20)->default('active')->after('aadhaar_card');
        });
    }

    private function copyUserColumnsToProfiles(): void
    {
        foreach (DB::table('users')->get() as $user) {
            $profile = DB::table('user_profiles')->where('user_id', $user->id)->first();
            $data = [
                'registration_number' => $this->firstFilled($profile->registration_number ?? null, $user->registration_number ?? null),
                'registration_date' => $this->firstFilled($profile->registration_date ?? null, $user->registration_date ?? null),
                'avatar' => $this->firstFilled($profile->avatar ?? null, $user->avatar ?? null),
                'image' => $this->firstFilled($profile->image ?? null, $user->image ?? null),
                'father_name' => $this->firstFilled($profile->father_name ?? null, $user->father_name ?? null),
                'dob' => $this->firstFilled($profile->dob ?? null, $user->date_of_birth ?? null),
                'mobile' => $this->firstFilled($profile->mobile ?? null, $user->mobile ?? null, $user->phone ?? null),
                'whatsapp' => $this->firstFilled($profile->whatsapp ?? null, $user->whatsapp ?? null),
                'address' => $this->firstFilled($profile->address ?? null, $user->address ?? null),
                'gender' => $this->firstFilled($profile->gender ?? null, $user->gender ?? null),
                'district' => $this->firstFilled($profile->district ?? null, $user->district ?? null),
                'school' => $this->firstFilled($profile->school ?? null, $user->school ?? null),
                'class' => $this->firstFilled($profile->class ?? null, $user->class ?? null),
                'designation' => $this->firstFilled($profile->designation ?? null, $user->designation ?? null),
                'department' => $this->firstFilled($profile->department ?? null, $user->department ?? null),
                'bio' => $this->firstFilled($profile->bio ?? null, $user->about ?? null),
                'aadhaar_number' => $this->firstFilled($profile->aadhaar_number ?? null, $user->aadhaar_number ?? null),
                'aadhaar_card' => $this->firstFilled($profile->aadhaar_card ?? null, $user->aadhaar_card ?? null),
                'status' => $this->firstFilled($profile->status ?? null, $user->status ?? null, 'active'),
                'updated_at' => now(),
            ];

            DB::table('user_profiles')->updateOrInsert(
                ['user_id' => $user->id],
                array_merge($data, ['created_at' => $profile->created_at ?? now()])
            );
        }
    }

    private function copyStudentsToUsersAndProfiles(): array
    {
        if (!Schema::hasTable('students')) {
            return [];
        }

        $studentIdMap = [];
        $students = Schema::hasColumn('students', 'deleted_at')
            ? DB::table('students')->whereNull('deleted_at')->get()
            : DB::table('students')->get();

        foreach ($students as $student) {
            $email = $student->email ?: ('student_' . $student->id . '@sumantech.local');
            $user = DB::table('users')
                ->where('email', $email)
                ->orWhere('phone', $student->mobile)
                ->first();

            if (!$user) {
                $userId = DB::table('users')->insertGetId([
                    'name' => $student->name,
                    'email' => $email,
                'password' => Hash::needsRehash($student->password ?: 'password123')
                    ? Hash::make($student->password ?: 'password123')
                    : $student->password,
                    'phone' => $student->mobile,
                    'role' => 'student',
                    'user_type' => 'student',
                    'is_active' => $student->status === 'active',
                    'created_at' => $student->created_at ?? now(),
                    'updated_at' => $student->updated_at ?? now(),
                ]);
            } else {
                $userId = $user->id;
                DB::table('users')->where('id', $userId)->update([
                    'role' => 'student',
                    'user_type' => 'student',
                    'phone' => $student->mobile,
                    'is_active' => $student->status === 'active',
                    'updated_at' => now(),
                ]);
            }

            $studentIdMap[$student->id] = $userId;
            DB::table('user_profiles')->updateOrInsert(
                ['user_id' => $userId],
                [
                    'registration_number' => $student->registration_number,
                    'registration_date' => $student->registration_date,
                    'father_name' => $student->father_name,
                    'dob' => $student->date_of_birth,
                    'mobile' => $student->mobile,
                    'whatsapp' => $student->whatsapp,
                    'address' => $student->address,
                    'image' => $student->image,
                    'aadhaar_number' => $student->aadhaar_number,
                    'aadhaar_card' => $student->aadhaar_card,
                    'gender' => $student->gender,
                    'status' => $student->status,
                    'created_at' => $student->created_at ?? now(),
                    'updated_at' => $student->updated_at ?? now(),
                ]
            );
        }

        return $studentIdMap;
    }

    private function moveStudentCourseForeignKey(array $studentIdMap): void
    {
        if (!Schema::hasTable('student_courses') || !Schema::hasColumn('student_courses', 'student_id')) {
            return;
        }

        if (!Schema::hasColumn('student_courses', 'user_id')) {
            Schema::table('student_courses', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->after('student_id');
            });
        }

        foreach ($studentIdMap as $oldStudentId => $newUserId) {
            DB::table('student_courses')->where('student_id', $oldStudentId)->update(['user_id' => $newUserId]);
            if (Schema::hasTable('invoices')) {
                DB::table('invoices')->where('user_id', $oldStudentId)->update(['user_id' => $newUserId]);
            }
        }

        try {
            Schema::table('student_courses', function (Blueprint $table) {
                $table->dropForeign(['student_id']);
            });
        } catch (Throwable $e) {
            //
        }

        Schema::table('student_courses', function (Blueprint $table) {
            $table->dropColumn('student_id');
        });
    }

    private function dropProfileColumnsFromUsers(): void
    {
        try {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'registration_number')) {
                    $table->dropUnique(['registration_number']);
                }
            });
        } catch (Throwable $e) {
            //
        }

        $columns = [
            'avatar', 'designation', 'department', 'about', 'district', 'school', 'class',
            'registration_number', 'registration_date', 'father_name', 'date_of_birth',
            'mobile', 'whatsapp', 'address', 'gender', 'image', 'aadhaar_number',
            'aadhaar_card', 'status',
        ];

        $existing = array_values(array_filter($columns, fn ($column) => Schema::hasColumn('users', $column)));
        if ($existing) {
            Schema::table('users', function (Blueprint $table) use ($existing) {
                $table->dropColumn($existing);
            });
        }
    }

    private function firstFilled(...$values): mixed
    {
        foreach ($values as $value) {
            if ($value !== null && $value !== '') {
                return $value;
            }
        }

        return null;
    }
};
