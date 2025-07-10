provider "aws" {
  region = "us-east-1"
}

# --- 1. Create Admin Group ---
resource "aws_iam_group" "admin_group" {
  name = "admin-group"
}

# Attach AdministratorAccess policy to the group
resource "aws_iam_group_policy_attachment" "admin_group_policy" {
  group      = aws_iam_group.admin_group.name
  policy_arn = "arn:aws:iam::aws:policy/AdministratorAccess"
}

# --- 2. Create IAM User ---
resource "aws_iam_user" "admin_user" {
  name = "admin-user"
  tags = {
    Purpose = "AdminAccess"
  }
  force_destroy = true  # Optional, allows destroying even with login profile or keys
}

# Add user to group
resource "aws_iam_user_group_membership" "admin_user_membership" {
  user = aws_iam_user.admin_user.name
  groups = [aws_iam_group.admin_group.name]
}

# --- 3. Console Login Profile with initial password ---
resource "aws_iam_user_login_profile" "admin_user_console" {
  user                   = aws_iam_user.admin_user.name
  password_reset_required = true
  password               = "TempPassword123!"  # 🔴 CHANGE THIS before use or use a variable
}

# --- 4. MFA Device (Virtual MFA Token) ---
resource "aws_iam_virtual_mfa_device" "admin_mfa" {
  name = "admin-user-mfa"
  path = "/"
  virtual_mfa_device_name = "admin-user"

  tags = {
    Owner = "admin-user"
  }
}

# Attach the MFA to the user (Manual step needed to enable using the OTP)
resource "aws_iam_user_mfa_device" "admin_user_mfa" {
  user           = aws_iam_user.admin_user.name
  serial_number  = aws_iam_virtual_mfa_device.admin_mfa.arn
  authentication_code_1 = "123456"  # 🔴 PLACEHOLDER
  authentication_code_2 = "654321"  # 🔴 PLACEHOLDER
}