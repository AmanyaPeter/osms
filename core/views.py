from django.shortcuts import render, redirect, get_object_or_404
from django.core.paginator import Paginator
from .models import Student
from django.db import models
from .forms import StudentForm, TeacherForm, CourseForm, TeacherAssignmentForm, EnrollmentForm, AttendanceForm

def home(request):
    return render(request, 'home.html')

def student_registration(request):
    if request.method == 'POST':
        form = StudentForm(request.POST, request.FILES)
        if form.is_valid():
            form.save()
            return redirect('home')  # Redirect to a success page or student list
    else:
        form = StudentForm()
    return render(request, 'student_registration.html', {'form': form})

def student_list(request):
    students_query = Student.objects.filter(is_deleted=False).order_by('full_name')

    # Search and filter
    query = request.GET.get('q')
    class_filter = request.GET.get('class_grade')
    status_filter = request.GET.get('status')

    if query:
        students_query = students_query.filter(
            models.Q(full_name__icontains=query) |
            models.Q(student_id__icontains=query) |
            models.Q(guardian_contact__icontains=query)
        )

    if class_filter:
        students_query = students_query.filter(class_grade=class_filter)

    if status_filter:
        students_query = students_query.filter(status=status_filter)

    paginator = Paginator(students_query, 25)
    page_number = request.GET.get('page')
    page_obj = paginator.get_page(page_number)

    context = {
        'page_obj': page_obj,
        'class_choices': Student.CLASS_CHOICES,
        'status_choices': Student.STATUS_CHOICES,
        'query': query,
        'class_filter': class_filter,
        'status_filter': status_filter,
    }

    return render(request, 'student_list.html', context)

def student_profile(request, student_id):
    student = get_object_or_404(Student, id=student_id)
    return render(request, 'student_profile.html', {'student': student})

def student_update(request, student_id):
    student = get_object_or_404(Student, id=student_id)
    if request.method == 'POST':
        form = StudentForm(request.POST, request.FILES, instance=student)
        if form.is_valid():
            student = form.save(commit=False)
            student.modified_by = request.user
            student.save()
            return redirect('student_profile', student_id=student.id)
    else:
        form = StudentForm(instance=student)
    return render(request, 'student_update.html', {'form': form, 'student': student})

def student_delete(request, student_id):
    student = get_object_or_404(Student, id=student_id)
    if request.method == 'POST':
        reason = request.POST.get('reason')
        if reason:
            student.is_deleted = True
            student.deletion_reason = reason
            student.modified_by = request.user
            student.save()
            return redirect('student_list')
    return render(request, 'student_delete.html', {'student': student})

def teacher_registration(request):
    if request.method == 'POST':
        form = TeacherForm(request.POST, request.FILES)
        if form.is_valid():
            teacher = form.save(commit=False)
            teacher.created_by = request.user
            teacher.save()
            return redirect('home') # Redirect to teacher profile page later
    else:
        form = TeacherForm()
    return render(request, 'teacher_registration.html', {'form': form})

def course_creation(request):
    if request.method == 'POST':
        form = CourseForm(request.POST)
        if form.is_valid():
            form.save()
            return redirect('home') # Redirect to course list page later
    else:
        form = CourseForm()
    return render(request, 'course_creation.html', {'form': form})

def teacher_assignment(request):
    if request.method == 'POST':
        form = TeacherAssignmentForm(request.POST)
        if form.is_valid():
            form.save()
            return redirect('home') # Redirect to assignment list page later
    else:
        form = TeacherAssignmentForm()
    return render(request, 'teacher_assignment.html', {'form': form})

def enrollment(request):
    if request.method == 'POST':
        form = EnrollmentForm(request.POST)
        if form.is_valid():
            form.save()
            return redirect('home') # Redirect to enrollment list page later
    else:
        form = EnrollmentForm()
    return render(request, 'enrollment.html', {'form': form})

def attendance(request):
    if request.method == 'POST':
        form = AttendanceForm(request.POST)
        if form.is_valid():
            form.save()
            return redirect('home') # Redirect to attendance list page later
    else:
        form = AttendanceForm()
    return render(request, 'attendance.html', {'form': form})
