from django.contrib import admin

from .models import Student, Teacher

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

@admin.register(Teacher)
class TeacherAdmin(admin.ModelAdmin):
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
            'fields': ('teacher_id', 'national_id', 'qualification', 'employment_date', 'employment_type', 'salary', 'status')
        }),
    )
