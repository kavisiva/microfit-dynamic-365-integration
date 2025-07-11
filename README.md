# Dynamics Sync Lite – WordPress Plugin for Microsoft Dynamics 365 Integration

**Dynamics Sync Lite** is a WordPress plugin that securely connects to Microsoft Dynamics 365 and allows **logged-in users** to view and update their own contact information using a user-friendly form and real-time AJAX submission.

---

## Microsoft Dynamics 365 Steps
### Steps to Register and Configure an Application in Microsoft Azure and Dynamics 365
 - #### Log in to the Microsoft Azure Portal
    - Access the portal at https://portal.azure.com.
 - #### Navigate to Microsoft Entra ID
    - From the left-hand menu, select Microsoft Entra ID.
 - #### Access App Registrations
    - Under Entra ID, click on App registrations.
 - #### Create a New App Registration
    - Select New registration, enter the required details, and create the application.
 - #### Record the Application (Client) ID and Directory (Tenant) ID
    - After creation, make a note of both the Client ID and Tenant ID for future use.
 - #### Generate a Client Secret
    - Under Certificates & secrets, create a new client secret. Ensure you securely store the generated value, as it will not be visible again
 - #### Configure API Permissions
    - Go to API permissions.
    - Select Microsoft Graph and add User.ReadWrite.All permission.
    - Also, add permissions for Dynamics CRM by selecting Delegated permissions > user_impersonation.
 - #### Retrieve CRM URL
    - Log in to Dynamics 365 and copy the CRM URL for the target environment.
 - #### Access Power Platform Admin Center
    - Navigate to the Power Platform Admin Center.
 - #### Select Environment and Configure Application User
    - Choose the appropriate environment.
    - Go to Settings > Users + Permissions > Application Users.
    - Select + New App User, and link the app you registered in Entra ID.
 - #### Assign Security Roles
    - Assign the Salesperson and System Customizer roles to the application user.

## Copy App Credentials
###After registration:
- Application (client) ID → Save as DSL_CLIENT_ID
-Directory (tenant) ID → Save as DSL_TENANT_ID

## Features

- Fetch contact info (name, phone, email, address) from Dynamics 365
- Update contact info via AJAX securely
- Uses `wp_localize_script()` for localized AJAX endpoint and nonce
- Only accessible to logged-in users
- Displays user feedback without reloading the page
- Clean shortcode integration: `[dsl_contact_form]`

---

## Installation

1. Upload the plugin files to the `/wp-content/plugins/dynamics-sync-lite` directory or install via WordPress Admin.
2. Activate the plugin through the **Plugins** screen in WordPress.
3. Ensure your `DSL_Api_Client` is correctly set up to connect with Microsoft Dynamics 365.
4. Define the required configuration constants in your `wp-config.php` 
5. Place the shortcode `[dsl_contact_form]` on any post or page.

## Configuration
Before using the plugin, define the following constants in your wp-config.php or a secure config file:
| Constant Name       | Description                               |
| ------------------- | ----------------------------------------- |
| `DSL_TENANT_ID`     | Your Azure AD Tenant ID                   |
| `DSL_CLIENT_ID`     | Azure AD Application (Client) ID          |
| `DSL_CLIENT_SECRET` | Azure AD Application Secret               |
| `DSL_SCOPE`         | OAuth scope (e.g., Dynamics CRM resource) |

### Example
- define( 'DSL_TENANT_ID',     'your-tenant-id' );
- define( 'DSL_CLIENT_ID',     'your-client-id' );
- define( 'DSL_CLIENT_SECRET', 'your-client-secret' );
- define( 'DSL_SCOPE',         'https://your-crm-resource/.default' );

---

## Usage

Add the following shortcode to display the contact update form:

```shortcode
[dsl_contact_form]
```

## Admin Options
### Dashboard Widget – “Dynamics Sync Updates”
- A dashboard widget is added to your WordPress admin dashboard that shows the 5 most recent contact updates made through the form.
- Displayed Information:
    - Full Name (First + Last Name)
    - Number of times the contact was updated
    - Last Updated Date & Time
- This helps admins quickly monitor activity without visiting a separate page.

### Admin Menu – Sync Activity Logs
- Navigate to WordPress Admin > Sync Activity
- This custom admin page displays all contact update logs stored in your custom database table (wp_dsl_contacts).

| Full Name  | Update Count | Last Updated        |
| ---------- | ------------ | ------------------- |
| John Doe   | 3            | 2025-07-10 14:23:55 |
| Jane Smith | 1            | 2025-07-09 09:13:21 |
| ...        | ...          | ...                 |
