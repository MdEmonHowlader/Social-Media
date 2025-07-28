// Notification management JavaScript

// Function to load notification statistics (for admin dashboard)
function loadNotificationStats() {
    fetch("/notifications/stats")
        .then((response) => response.json())
        .then((data) => {
            const message = `📊 Notification Statistics:
            
• Total Notifications: ${data.total_notifications}
• Unread Notifications: ${data.unread_notifications}
• Sent Today: ${data.notifications_today}
• Sent This Week: ${data.notifications_this_week}
• Sent This Month: ${data.notifications_this_month}`;

            alert(message);
        })
        .catch((error) => {
            console.error("Error loading notification stats:", error);
            alert("Failed to load notification statistics");
        });
}

// Function to mark notification as read via AJAX
function markNotificationAsRead(notificationId) {
    fetch(`/notifications/${notificationId}/mark-read`, {
        method: "PATCH",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                // Remove the notification from the UI or update its appearance
                const notificationElement = document.querySelector(
                    `[data-notification-id="${notificationId}"]`
                );
                if (notificationElement) {
                    notificationElement.classList.remove(
                        "bg-blue-50",
                        "border-blue-200"
                    );
                    notificationElement.classList.add(
                        "bg-gray-50",
                        "border-gray-200"
                    );

                    // Remove "New" badge
                    const newBadge =
                        notificationElement.querySelector(".bg-blue-100");
                    if (newBadge) {
                        newBadge.remove();
                    }
                }

                // Update notification count
                updateNotificationCount();
            }
        })
        .catch((error) => {
            console.error("Error marking notification as read:", error);
        });
}

// Function to update notification count in navbar
function updateNotificationCount() {
    fetch("/notifications/count")
        .then((response) => response.json())
        .then((data) => {
            const badges = document.querySelectorAll(
                ".notification-count-badge"
            );
            badges.forEach((badge) => {
                if (data.unread_count > 0) {
                    badge.textContent =
                        data.unread_count > 99 ? "99+" : data.unread_count;
                    badge.style.display = "inline-flex";
                } else {
                    badge.style.display = "none";
                }
            });
        })
        .catch((error) => {
            console.error("Error updating notification count:", error);
        });
}

// Function to mark all notifications as read
function markAllNotificationsAsRead() {
    fetch("/notifications/mark-all-read", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                // Refresh the page or update the UI
                location.reload();
            }
        })
        .catch((error) => {
            console.error("Error marking all notifications as read:", error);
        });
}

// Auto-refresh notification count every 30 seconds
setInterval(updateNotificationCount, 30000);

// Initialize on page load
document.addEventListener("DOMContentLoaded", function () {
    updateNotificationCount();
});
