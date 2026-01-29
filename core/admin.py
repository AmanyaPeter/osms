from django.contrib import admin
from django.contrib.auth.admin import UserAdmin
from .models import User, Student, Teacher, Subject, Course, TeacherAssignment, Enrollment, Attendance, Assessment, Grade, AuditLog

@admin.register(User)
class CustomUserAdmin(UserAdmin):
    fieldsets = UserAdmin.fieldsets + (
        ('Role Information', {'fields': ('role',)}),
    )
    list_display = UserAdmin.list_display + ('role',)

@admin.register(Student)
class StudentAdmin(admin.ModelAdmin):
    list_display = ('student_id', 'full_name', 'class_grade', 'guardian_name', 'guardian_contact', 'status')
    search_fields = ('student_id', 'full_name', 'guardian_contact')
    list_filter = ('class_grade', 'status', 'gender')
    readonly_fields = ('student_id',)
    fieldsets = (
        ('Personal Information', {
            'fields': ('full_name', 'date_of_birth', 'gender', 'student_photo')
        }),
        ('Academic Information', {
            'fields': ('student_id', 'class_grade', 'admission_date', 'status')
        }),
        ('Guardian Information', {
            'fields': ('guardian_name', 'guardian_contact', 'guardian_email', 'home_address')
        }),
        ('Other Information', {
            'fields': ('medical_conditions', 'previous_school')
        }),
    )

from .forms import TeacherForm

@admin.register(Teacher)
class TeacherAdmin(admin.ModelAdmin):
    form = TeacherForm
    list_display = ('teacher_id', 'full_name', 'contact_phone', 'email', 'qualification', 'status')
    search_fields = ('teacher_id', 'full_name', 'email')
    list_filter = ('qualification', 'employment_type', 'status')
    readonly_fields = ('teacher_id',)
    fieldsets = (
        ('Personal Information', {
            'fields': ('full_name', 'date_of_birth', 'gender', 'teacher_photo')
        }),
        ('Contact Information', {
            'fields': ('contact_phone', 'email', 'address', 'emergency_contact')
        }),
        ('Professional Information', {
            'fields': ('teacher_id', 'national_id', 'qualification', 'subject_specialization', 'employment_date', 'employment_type', 'salary', 'status')
        }),
    )

@admin.register(Subject)
class SubjectAdmin(admin.ModelAdmin):
    list_display = ('name',)
    search_fields = ('name',)

@admin.register(Course)
class CourseAdmin(admin.ModelAdmin):
    list_display = ('course_code', 'course_name', 'grade_level', 'course_type', 'status')
    search_fields = ('course_code', 'course_name')
    list_filter = ('grade_level', 'course_type', 'status')

@admin.register(TeacherAssignment)
class TeacherAssignmentAdmin(admin.ModelAdmin):
    list_display = ('teacher', 'course', 'class_grade', 'term', 'academic_year')
    list_filter = ('teacher', 'course', 'class_grade', 'term', 'academic_year')

@admin.register(Enrollment)
class EnrollmentAdmin(admin.ModelAdmin):
    list_display = ('student', 'course', 'term', 'academic_year', 'enrollment_date')
    list_filter = ('student', 'course', 'term', 'academic_year')

@admin.register(Attendance)
class AttendanceAdmin(admin.ModelAdmin):
    list_display = ('student', 'course', 'date', 'status')
    list_filter = ('student', 'course', 'date', 'status')

@admin.register(Assessment)
class AssessmentAdmin(admin.ModelAdmin):
    list_display = ('assessment_name', 'course', 'assessment_type', 'date', 'max_score')
    list_filter = ('course', 'assessment_type', 'date')

@admin.register(Grade)
class GradeAdmin(admin.ModelAdmin):
    list_display = ('student', 'assessment', 'score')
    list_filter = ('student', 'assessment')

@admin.register(AuditLog)
class AuditLogAdmin(admin.ModelAdmin):
    list_display = ('user', 'action', 'timestamp', 'ip_address')
    list_filter = ('user', 'action', 'timestamp')
    search_fields = ('action', 'details', 'user__username')
    readonly_fields = ('user', 'action', 'timestamp', 'details', 'ip_address')
