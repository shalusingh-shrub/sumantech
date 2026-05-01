# Schema Issues Report
Generated: 2026-04-30

## ISSUES FOUND

### 1. DUPLICATE DATA — users + user_profiles + students
- `users` table has student fields (registration_number, father_name, etc.)
- `user_profiles` table has same fields (registration_number, father_name, etc.)
- `students` table still exists with same data
- **FIX**: Keep `user_profiles` as single source of truth, clean `users` table

### 2. users table — Redundant columns
- `registration_number` → already in user_profiles ⚠️
- `registration_date` → already in user_profiles ⚠️
- `father_name` → already in user_profiles ⚠️
- `date_of_birth` → already in user_profiles (as `dob`) ⚠️
- `mobile` → already in user_profiles ⚠️
- `whatsapp` → already in user_profiles ⚠️
- `address` → already in user_profiles ⚠️
- `gender` → already in user_profiles ⚠️
- `image` → already in user_profiles ⚠️
- `aadhaar_number` → already in user_profiles ⚠️
- `aadhaar_card` → already in user_profiles ⚠️
- `status` → already in user_profiles ⚠️
- `district`, `school`, `class` → already in user_profiles ⚠️
- `avatar`, `designation`, `department`, `about` → already in user_profiles ⚠️
- **RISK**: HIGH — removing these will break existing code

### 3. user_profiles — Missing columns
- `percentage` column missing (used in student marks)
- `student_id` reference removed but some code may still use it

### 4. students table — Orphan table
- Data already migrated to users
- Still exists in DB
- **FIX**: Can be dropped after verification

### 5. quizzes table — Duplicate columns
- `title` and `quiz_name` both exist (same data)
- `total_views` and `quiz_views` both exist
- `total_attempts` and `quiz_taken` both exist
- **FIX**: Use title, total_views, total_attempts as primary

### 6. student_marks — Missing percentage column
- Code calculates percentage but doesn't store it
- **FIX**: Add `percentage` column

### 7. student_courses — Missing foreign key
- `user_id` has no FK constraint to users
- `course_id` has no FK constraint to courses

### 8. course_categories — Confusing structure
- Has `course_id` FK but category should be parent of course
- Should be reverse relationship

### 9. galleries — Old table
- Old `galleries` table exists alongside new `gallery_groups`
- `galleries` is orphan — not used in new code

### 10. Missing indexes
- `quiz_results.participant_email` — no index (slow search)
- `student_courses.user_id` — has index ✅
- `invoices.user_id` — has index ✅

## SAFE TO DROP (after verification)
- `students` table (data migrated)
- `galleries` table (replaced by gallery_groups)

## DATATYPE MISMATCHES
- `users.registration_date` = varchar(255) → should be date
- `students.mobile` = varchar(255) → should be varchar(20)
- `quizzes.quiz_name` = varchar(255) nullable → redundant with title