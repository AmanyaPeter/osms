from django.urls import path
from . import views

urlpatterns = [
    path('', views.home, name='home'),
    path('students/register/', views.student_registration, name='student_registration'),
    path('students/', views.student_list, name='student_list'),
    path('students/<int:student_id>/', views.student_profile, name='student_profile'),
    path('students/<int:student_id>/update/', views.student_update, name='student_update'),
    path('students/<int:student_id>/delete/', views.student_delete, name='student_delete'),
    path('teachers/register/', views.teacher_registration, name='teacher_registration'),
]
