# WordPress Maintenance Mode with Admin Toggle

This functionality allows you to enable or disable maintenance mode on your WordPress site. When maintenance mode is enabled, all non-logged-in users are redirected to a specific maintenance page, while administrators and logged-in users retain full access to the site.

## Features
- Redirect non-logged-in users to a maintenance page.
- Admins and logged-in users are exempt from redirection and retain access to all pages, including the WordPress admin dashboard.
- Toggle maintenance mode directly from the WordPress admin bar.
- Dynamic styling for the toggle button in the admin bar to indicate the current maintenance mode status.

## Installation

1. **Create a `maintenance-mode.php` File**  
   Place the following code in a new file named `maintenance-mode.php` in your theme folder. You can install a code snippet plugin as well to make it easier for you.

3. **Set Up Maintenance Page**  
   - Create a page with the slug `/maintenance/`.
   - You can copy and paste the maintenance page here [maintenance](../maintenance.html) or create your own 

4. **Clear Cache**  
   If you’re using a caching plugin, clear the cache to ensure the new functionality works as expected.

## How It Works

1. **Maintenance Mode Toggle**  
   - A toggle button is added to the admin bar for users with admin privileges.
   - Clicking the button enables or disables maintenance mode via an AJAX request.

2. **Redirect Logic**  
   - When maintenance mode is on, non-logged-in users trying to access any front-end page (`/home`, `/about`, etc.) are redirected to `/maintenance/`.
   - Logged-in users, including admins, can browse the site normally.

3. **Admin Bar Styling**  
   - The admin bar button dynamically updates its label and color to indicate whether maintenance mode is ON or OFF.

## Code Explanation

### Redirect Logic
The `check_maintenance_mode` function uses the `init` hook to ensure all front-end requests by non-logged-in users are redirected to the maintenance page when maintenance mode is enabled.

### Admin Bar Toggle
- The `add_maintenance_toggle_button` function adds a toggle button to the admin bar.
- The `handle_maintenance_toggle` function handles the AJAX request to update the maintenance mode status.

### Styling and User Experience
- Inline CSS styles the admin bar button.
- JavaScript dynamically reloads the page after toggling the maintenance mode for an updated experience.

## Usage

1. **Enable Maintenance Mode**  
   - Go to the WordPress admin bar and click the toggle button labeled **"Maintenance: OFF"**.
   - The button changes to **"Maintenance: ON"**, and maintenance mode is enabled.

2. **Disable Maintenance Mode**  
   - Click the toggle button labeled **"Maintenance: ON"**.
   - The button changes back to **"Maintenance: OFF"**, and the site resumes normal functionality.

## Requirements

- WordPress 5.0 or higher.
- Administrative access to the WordPress dashboard.
- A page with the slug `/maintenance/`.

## Known Limitations
- The `/maintenance/` page must exist and be publicly accessible.
- Caching plugins might interfere; clear your cache after enabling/disabling maintenance mode.
