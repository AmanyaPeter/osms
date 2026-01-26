from django import forms
from .models import Student, Teacher, Course

class StudentForm(forms.ModelForm):
    class Meta:
        model = Student
        fields = [
            'full_name', 'date_of_birth', 'gender', 'class_grade',
            'guardian_name', 'guardian_contact', 'guardian_email', 'home_address',
            'student_photo', 'medical_conditions', 'previous_school', 'admission_date', 'status'
        ]
        widgets = {
            'date_of_birth': forms.DateInput(attrs={'type': 'date'}),
            'admission_date': forms.DateInput(attrs={'type': 'date'}),
            'home_address': forms.Textarea(attrs={'rows': 3}),
            'medical_conditions': forms.Textarea(attrs={'rows': 3}),
        }

    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        for field_name, field in self.fields.items():
            field.widget.attrs['class'] = 'form-control'

class TeacherForm(forms.ModelForm):
    class Meta:
        model = Teacher
        fields = [
            'full_name', 'date_of_birth', 'gender', 'contact_phone', 'email',
            'national_id', 'qualification', 'employment_date', 'employment_type',
            'salary', 'teacher_photo', 'address', 'emergency_contact', 'status'
        ]
        widgets = {
            'date_of_birth': forms.DateInput(attrs={'type': 'date'}),
            'employment_date': forms.DateInput(attrs={'type': 'date'}),
            'address': forms.Textarea(attrs={'rows': 3}),
        }

    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        for field_name, field in self.fields.items():
            field.widget.attrs['class'] = 'form-control'


class CourseForm(forms.ModelForm):
    class Meta:
        model = Course
        fields = [
            'course_code', 'course_name', 'grade_level', 'course_type',
            'credit_hours', 'description', 'status'
        ]
        widgets = {
            'description': forms.Textarea(attrs={'rows': 3}),
        }

    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        for field_name, field in self.fields.items():
            field.widget.attrs['class'] = 'form-control'
