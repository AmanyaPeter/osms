from django.test import TestCase, Client
from django.urls import reverse
from .models import User, Teacher, Student
from decimal import Decimal
import datetime

class AuthTest(TestCase):
    def setUp(self):
        self.user = User.objects.create_user(username='testuser', password='password', role='Teacher')

    def test_login(self):
        response = self.client.post(reverse('login'), {'username': 'testuser', 'password': 'password'})
        self.assertEqual(response.status_code, 302)
        self.assertRedirects(response, reverse('home'))

    def test_role_access(self):
        self.client.login(username='testuser', password='password')
        # Teacher should NOT be able to access student_registration
        response = self.client.get(reverse('student_registration'))
        self.assertEqual(response.status_code, 403)

class TeacherTest(TestCase):
    def test_salary_encryption(self):
        teacher = Teacher.objects.create(
            full_name="John Doe",
            date_of_birth=datetime.date(1980, 1, 1),
            gender="Male",
            contact_phone="0712345678",
            email="john@example.com",
            national_id="NID123",
            qualification="Degree",
            employment_date=datetime.date(2020, 1, 1),
            employment_type="Permanent",
            address="Kampala",
            emergency_contact="0787654321"
        )
        teacher.salary = Decimal('500000.00')
        teacher.save()

        # Refresh from DB
        teacher = Teacher.objects.get(id=teacher.id)
        self.assertEqual(teacher.salary, Decimal('500000.00'))
        self.assertNotEqual(teacher.salary_encrypted, '500000.00')
