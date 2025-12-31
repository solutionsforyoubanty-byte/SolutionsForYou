# ============================================
# NGROK CONFIGURATION GUIDE
# ============================================

# Jab localhost pe test kar rahe ho:
# APP_URL=http://localhost:8000

# Jab ngrok use kar rahe ho, do options hain:

# Option 1: Manual - apna ngrok URL paste karo
# Pehle ngrok terminal se URL copy karo, phir yahan paste karo:
# APP_URL=https://your-unique-id.ngrok.io

# Option 2: Automatic
# Terminal se run karo:
# php update-ngrok-url.php
# Ye automatically APP_URL set kar dega

# ============================================
# IMPORTANT SETTINGS FOR NGROK:
# ============================================

# Ensure SESSION_DOMAIN is not set (or set to null)
# SESSION_DOMAIN=null

# Or add your ngrok domain:
# SESSION_DOMAIN=.ngrok.io

# CORS settings - allow ngrok domain
# CORS_ALLOWED_ORIGINS=*

# ============================================
