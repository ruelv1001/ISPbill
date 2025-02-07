<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class AuthHelper
{
    public static function redirectToDashboard()
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Get the authenticated user
            $user = Auth::user();

            // Redirect based on the user's role
            switch ($user->role->role) {
                case 'SOT Admin':
                    return redirect()->route('dashboard'); // Redirect to SOT Admin dashboard
                case 'School Admin':
                    return redirect()->route('school-dashboard'); // Redirect to School Admin dashboard
                case 'Faculty':
                    return redirect()->route('faculty-dashboard'); // Redirect to Faculty Admin dashboard
                default:
                    return redirect('/login'); // Redirect to home if the role doesn't match any expected ones
            }
        }

        // Return null if the user is not authenticated
        return null;
    }

    /**
     * Get the appropriate dashboard URL based on the user's role.
     *
     * @return string|null
     */
    public static function getDashboardUrl()
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Get the authenticated user
            $user = Auth::user();

            // Return the dashboard URL based on the user's role
            switch ($user->role->role) {
                case 'SOT Admin':
                    return route('dashboard'); // SOT Admin dashboard route
                case 'School Admin':
                    return route('school-dashboard'); // School Admin dashboard route
                case 'Faculty':
                    return route('faculty-dashboard'); // Faculty dashboard route
                default:
                    return null; // Return null if the role doesn't match any expected ones
            }
        }

        // Return null if the user is not authenticated
        return null;
    }

    /**
     * Check user is deleted.
     *
     * @return boolean
     */
    public static function isUserDeleted()
    {
        // Check if the user is deleted
        if (Auth::user()->deleted_at) {
            return true;
        }
        return false;
    }
    /**
     * Check user is suspended.
     *
     * @return boolean
     */
    public static function isUserSuspended()
    {
        // Check if the user is suspended
        if (Auth::user()->user_status_id != 1) {
            return true;
        }
        return false;
    }

    /**
     * Check user is sot admin.
     *
     * @return boolean
     */
    public static function isUserSotAdmin()
    {
        // Check if the user is suspended
        if (Auth::user()->role->role == 'SOT Admin') {
            return true;
        }
        return false;
    }
}

