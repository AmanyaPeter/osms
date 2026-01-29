from cryptography.fernet import Fernet
from django.conf import settings
import base64
import hashlib

def get_cipher():
    key = base64.urlsafe_b64encode(hashlib.sha256(settings.SECRET_KEY.encode()).digest())
    return Fernet(key)

def encrypt_value(value):
    if value is None:
        return None
    cipher = get_cipher()
    return cipher.encrypt(str(value).encode()).decode()

def decrypt_value(encrypted_value):
    if not encrypted_value:
        return None
    cipher = get_cipher()
    return cipher.decrypt(encrypted_value.encode()).decode()

def log_action(user, action, details=None, request=None):
    from .models import AuditLog
    ip = None
    if request:
        x_forwarded_for = request.META.get('HTTP_X_FORWARDED_FOR')
        if x_forwarded_for:
            ip = x_forwarded_for.split(',')[0]
        else:
            ip = request.META.get('REMOTE_ADDR')

    AuditLog.objects.create(
        user=user,
        action=action,
        details=details,
        ip_address=ip
    )
