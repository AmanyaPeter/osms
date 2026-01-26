from django.db import models
from django.conf import settings
from django.core.validators import RegexValidator, MinValueValidator, MaxValueValidator
from django.utils import timezone
from django.core.exceptions import ValidationError
import datetime

def validate_age(birth_date):
    today = datetime.date.today()
    age = today.year - birth_date.year - ((today.month, today.day) < (birth_date.month, birth_date.day))
    if not 3 <= age <= 25:
        raise ValidationError('Student age must be between 3 and 25 years.')

class Student(models.Model):
    """
    Model representing a student, based on FR-STU-001.
    """
    # Choices
    GENDER_CHOICES = [('Male', 'Male'), ('Female', 'Female')]
    CLASS_CHOICES = [(f'P{i}', f'P{i}') for i in range(1, 8)] + [(f'S{i}', f'S{i}') for i in range(1, 7)]
    STATUS_CHOICES = [('Active', 'Active'), ('Inactive', 'Inactive'), ('Graduated', 'Graduated')]

    # Validators
    uganda_phone_validator = RegexValidator(regex=r'^07[0-9]{8}$', message="Phone number must be 10 digits and start with '07'.")

    # Fields
    student_id = models.CharField(max_length=20, unique=True, editable=False, blank=True)
    full_name = models.CharField(max_length=255)
    date_of_birth = models.DateField(validators=[validate_age])
    gender = models.CharField(max_length=6, choices=GENDER_CHOICES)
    class_grade = models.CharField(max_length=3, choices=CLASS_CHOICES)
    guardian_name = models.CharField(max_length=255)
    guardian_contact = models.CharField(validators=[uganda_phone_validator], max_length=10)
    guardian_email = models.EmailField(blank=True, null=True)
    home_address = models.TextField()
    student_photo = models.ImageField(upload_to='students/photos/', validators=[]) # Max size validation will be handled in forms
    medical_conditions = models.TextField(blank=True, null=True)
    previous_school = models.CharField(max_length=255, blank=True, null=True)
    admission_date = models.DateField(default=timezone.now)
    status = models.CharField(max_length=10, choices=STATUS_CHOICES, default='Active')
    created_by = models.ForeignKey(settings.AUTH_USER_MODEL, on_delete=models.SET_NULL, null=True, related_name='created_students', blank=True)
    created_at = models.DateTimeField(auto_now_add=True, null=True)
    modified_by = models.ForeignKey(settings.AUTH_USER_MODEL, on_delete=models.SET_NULL, null=True, blank=True, related_name='modified_students')
    modified_at = models.DateTimeField(auto_now=True, null=True)
    is_deleted = models.BooleanField(default=False)
    deletion_reason = models.TextField(blank=True, null=True)

    def __str__(self):
        return f'{self.full_name} ({self.student_id})'

    def save(self, *args, **kwargs):
        if not self.student_id:
            last_student = Student.objects.all().order_by('id').last()
            last_id = last_student.id if last_student else 0
            year = datetime.date.today().year
            self.student_id = f'STU-{year}-{last_id + 1:04d}'
        super(Student, self).save(*args, **kwargs)

class Teacher(models.Model):
    """
    Model representing a teacher, based on FR-TEA-001.
    """
    # Choices
    GENDER_CHOICES = [('Male', 'Male'), ('Female', 'Female')]
    QUALIFICATION_CHOICES = [
        ('Certificate', 'Certificate'),
        ('Diploma', 'Diploma'),
        ('Degree', 'Degree'),
        ('Masters', 'Masters'),
        ('PhD', 'PhD'),
    ]
    EMPLOYMENT_CHOICES = [
        ('Permanent', 'Permanent'),
        ('Contract', 'Contract'),
        ('Part-time', 'Part-time'),
    ]
    STATUS_CHOICES = [
        ('Active', 'Active'),
        ('On Leave', 'On Leave'),
        ('Terminated', 'Terminated'),
    ]

    # Validators
    uganda_phone_validator = RegexValidator(regex=r'^07[0-9]{8}$', message="Phone number must be 10 digits and start with '07'.")

    # Fields
    teacher_id = models.CharField(max_length=20, unique=True, editable=False, blank=True)
    full_name = models.CharField(max_length=255)
    date_of_birth = models.DateField()
    gender = models.CharField(max_length=6, choices=GENDER_CHOICES)
    contact_phone = models.CharField(validators=[uganda_phone_validator], max_length=10)
    email = models.EmailField(unique=True)
    national_id = models.CharField(max_length=20, unique=True)
    qualification = models.CharField(max_length=20, choices=QUALIFICATION_CHOICES)
    subject_specialization = models.ManyToManyField('Subject', blank=True)
    employment_date = models.DateField()
    employment_type = models.CharField(max_length=20, choices=EMPLOYMENT_CHOICES)
    salary = models.DecimalField(max_digits=10, decimal_places=2, null=True, blank=True) # Should be encrypted
    teacher_photo = models.ImageField(upload_to='teachers/photos/', blank=True, null=True)
    address = models.TextField()
    emergency_contact = models.CharField(validators=[uganda_phone_validator], max_length=10)
    status = models.CharField(max_length=20, choices=STATUS_CHOICES, default='Active')

    created_by = models.ForeignKey(settings.AUTH_USER_MODEL, on_delete=models.SET_NULL, null=True, blank=True, related_name='created_teachers')
    created_at = models.DateTimeField(auto_now_add=True, null=True)
    modified_by = models.ForeignKey(settings.AUTH_USER_MODEL, on_delete=models.SET_NULL, null=True, blank=True, related_name='modified_teachers')
    modified_at = models.DateTimeField(auto_now=True, null=True)
    is_deleted = models.BooleanField(default=False)

    def __str__(self):
        return self.full_name

    def save(self, *args, **kwargs):
        if not self.teacher_id:
            last_teacher = Teacher.objects.all().order_by('id').last()
            last_id = last_teacher.id if last_teacher else 0
            year = datetime.date.today().year
            self.teacher_id = f'TEA-{year}-{last_id + 1:04d}'
        super(Teacher, self).save(*args, **kwargs)

class Subject(models.Model):
    """
    Model representing a subject that can be taught.
    """
    name = models.CharField(max_length=100, unique=True)

    def __str__(self):
        return self.name

class Course(models.Model):
    """
    Model representing a course, based on FR-COU-001.
    """
    # Choices
    GRADE_LEVEL_CHOICES = [(f'P{i}', f'P{i}') for i in range(1, 8)] + [(f'S{i}', f'S{i}') for i in range(1, 7)]
    COURSE_TYPE_CHOICES = [
        ('Core', 'Core'),
        ('Elective', 'Elective'),
        ('Extra-curricular', 'Extra-curricular'),
    ]
    STATUS_CHOICES = [('Active', 'Active'), ('Inactive', 'Inactive')]

    # Fields
    course_code = models.CharField(max_length=20, unique=True, editable=False, blank=True)
    course_name = models.CharField(max_length=255)
    grade_level = models.CharField(max_length=3, choices=GRADE_LEVEL_CHOICES)
    course_type = models.CharField(max_length=20, choices=COURSE_TYPE_CHOICES)
    credit_hours = models.PositiveIntegerField(null=True, blank=True)
    description = models.TextField(blank=True, null=True)
    status = models.CharField(max_length=10, choices=STATUS_CHOICES, default='Active')

    class Meta:
        unique_together = ('course_name', 'grade_level')

    def __str__(self):
        return f'{self.course_name} ({self.course_code})'

    def save(self, *args, **kwargs):
        if not self.course_code:
            name_parts = self.course_name.upper().split()
            if len(name_parts) > 1:
                initials = "".join(part[0] for part in name_parts)
            else:
                initials = name_parts[0][:4]
            self.course_code = f'{initials}-{self.grade_level}'
        super(Course, self).save(*args, **kwargs)

class TeacherAssignment(models.Model):
    """
    Model representing the assignment of a teacher to a course for a specific class, term, and year.
    """
    # Choices
    TERM_CHOICES = [('Term 1', 'Term 1'), ('Term 2', 'Term 2'), ('Term 3', 'Term 3')]

    # Fields
    teacher = models.ForeignKey(Teacher, on_delete=models.CASCADE)
    course = models.ForeignKey(Course, on_delete=models.CASCADE)
    class_grade = models.CharField(max_length=3, choices=Student.CLASS_CHOICES)
    term = models.CharField(max_length=10, choices=TERM_CHOICES)
    academic_year = models.PositiveIntegerField()

    class Meta:
        unique_together = ('course', 'class_grade', 'term', 'academic_year')

    def __str__(self):
        return f'{self.teacher} - {self.course} ({self.class_grade}) - {self.term} {self.academic_year}'

class Enrollment(models.Model):
    """
    Model representing a student's enrollment in a course for a specific term and year.
    """
    # Fields
    student = models.ForeignKey(Student, on_delete=models.CASCADE)
    course = models.ForeignKey(Course, on_delete=models.CASCADE)
    term = models.CharField(max_length=10, choices=TeacherAssignment.TERM_CHOICES)
    academic_year = models.PositiveIntegerField()
    enrollment_date = models.DateField(auto_now_add=True)

    class Meta:
        unique_together = ('student', 'course', 'term', 'academic_year')

    def __str__(self):
        return f'{self.student} enrolled in {self.course} for {self.term} {self.academic_year}'

class Attendance(models.Model):
    """
    Model representing a student's attendance for a specific course on a given date.
    """
    # Choices
    STATUS_CHOICES = [
        ('Present', 'Present'),
        ('Absent', 'Absent'),
        ('Late', 'Late'),
        ('Excused', 'Excused'),
    ]

    # Fields
    student = models.ForeignKey(Student, on_delete=models.CASCADE)
    course = models.ForeignKey(Course, on_delete=models.CASCADE)
    date = models.DateField()
    status = models.CharField(max_length=10, choices=STATUS_CHOICES)
    remarks = models.TextField(blank=True, null=True)

    class Meta:
        unique_together = ('student', 'course', 'date')

    def __str__(self):
        return f'{self.student} - {self.course} on {self.date}: {self.status}'
