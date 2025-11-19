<?php

namespace Dash;

/**
 * Abstract Notification Class
 *
 * Base class for creating dashboard notification handlers.
 * Extend this class to create custom notification types that can be
 * displayed in the dashboard header or notification center.
 *
 * Child classes should override the static methods to provide:
 * - stack() - Array of notifications to display
 * - unreadCount() - Number of unread notifications
 * - content() - HTML content for rendering notifications
 *
 * @package Dash
 */
abstract class Notification
{
    /**
     * Get notification stack
     *
     * Returns an array of notification items to be displayed.
     * Override this method in child classes to return actual notifications.
     *
     * Expected array structure:
     * [
     *     [
     *         'id' => 1,
     *         'title' => 'Notification Title',
     *         'message' => 'Notification message',
     *         'url' => '/notification/url',
     *         'read' => false,
     *         'created_at' => '2024-01-01 12:00:00'
     *     ],
     *     ...
     * ]
     *
     * @return array Array of notification items
     */
    public static function stack()
    {
        return [];
    }

    /**
     * Get unread notification count
     *
     * Returns the number of unread notifications for the current user.
     * Override this method in child classes to return the actual count.
     *
     * This count is typically displayed as a badge in the dashboard header.
     *
     * @return int Number of unread notifications
     */
    public static function unreadCount()
    {
        return 0;
    }

    /**
     * Get notification content HTML
     *
     * Returns the HTML content for rendering the notifications.
     * Override this method in child classes to return custom notification markup.
     *
     * The returned HTML will be rendered in the notification dropdown
     * or notification center in the dashboard.
     *
     * @return string HTML content for notifications
     */
    public static function content()
    {
        return '<p>Notification Not Setted</p>';
    }
}
