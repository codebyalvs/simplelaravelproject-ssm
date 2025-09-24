class NotificationManager {
    constructor() {
        this.container = null;
        this.notifications = new Map();
        this.defaultDuration = 5000;
        this.maxNotifications = 5;
    }

    init() {
        this.createContainer();
        this.processExistingAlerts();
        this.setupGlobalErrorHandling();
    }

    createContainer() {
        if (this.container) return;

        this.container = document.createElement('div');
        this.container.id = 'notification-container';
        this.container.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            pointer-events: none;
            max-width: 400px;
        `;

        document.body.appendChild(this.container);
    }

    processExistingAlerts() {
        const existingAlerts = document.querySelectorAll('.alert');
        existingAlerts.forEach(alert => {
            this.convertAlertToNotification(alert);
        });
    }

    convertAlertToNotification(alertElement) {
        let type = 'info';
        let message = alertElement.textContent.trim();

        message = message.replace(/×/g, '').trim();

        if (alertElement.classList.contains('alert-success')) {
            type = 'success';
        } else if (alertElement.classList.contains('alert-danger')) {
            type = 'error';
        } else if (alertElement.classList.contains('alert-warning')) {
            type = 'warning';
        }

        this.show(message, type, this.defaultDuration);

        alertElement.classList.add('converted-to-notification');
        alertElement.style.display = 'none';

        const closeButtons = alertElement.querySelectorAll('.alert-close, button[data-dismiss], .btn-close');
        closeButtons.forEach(btn => btn.remove());
    }

    show(message, type = 'info', duration = null) {
        if (!this.container) this.createContainer();

        duration = duration || this.defaultDuration;
        const id = this.generateId();

        this.limitNotifications();

        const notification = this.createElement(id, message, type);
        this.container.appendChild(notification);
        this.notifications.set(id, notification);

        setTimeout(() => {
            notification.classList.add('notification-show');
        }, 10);

        if (duration > 0) {
            setTimeout(() => {
                this.remove(id);
            }, duration);
        }

        return id;
    }

    createElement(id, message, type) {
        const notification = document.createElement('div');
        notification.id = `notification-${id}`;
        notification.className = `notification notification-${type}`;

        const colors = {
            success: { bg: '#ecfdf5', border: '#10b981', text: '#065f46' },
            error: { bg: '#fef2f2', border: '#ef4444', text: '#991b1b' },
            warning: { bg: '#fffbeb', border: '#f59e0b', text: '#92400e' },
            info: { bg: '#eff6ff', border: '#3b82f6', text: '#1e40af' }
        };

        const color = colors[type] || colors.info;

        notification.style.cssText = `
            background: ${color.bg};
            border: 1px solid ${color.border};
            border-left: 4px solid ${color.border};
            color: ${color.text};
            padding: 16px 40px 16px 20px;
            margin-bottom: 12px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateX(100%);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: auto;
            position: relative;
            word-wrap: break-word;
            max-width: 400px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
            line-height: 1.5;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        `;

        const icon = this.getIcon(type);
        const iconElement = document.createElement('span');
        iconElement.innerHTML = icon;
        iconElement.style.cssText = `
            display: inline-block;
            font-weight: bold;
            font-size: 16px;
            margin-top: 1px;
            flex-shrink: 0;
        `;

        const messageWrapper = document.createElement('div');
        messageWrapper.style.cssText = `
            flex-grow: 1;
            padding-right: 8px;
        `;

        const messageElement = document.createElement('span');
        messageElement.textContent = message;
        messageWrapper.appendChild(messageElement);

        const closeButton = document.createElement('button');
        closeButton.innerHTML = '×';
        closeButton.setAttribute('aria-label', 'Close notification');
        closeButton.style.cssText = `
            position: absolute;
            top: 8px;
            right: 8px;
            background: none;
            border: none;
            font-size: 18px;
            font-weight: bold;
            color: inherit;
            opacity: 0.7;
            cursor: pointer;
            line-height: 1;
            padding: 0;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            transition: all 0.2s ease;
        `;

        closeButton.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            this.remove(id);
        });

        closeButton.addEventListener('mouseenter', () => {
            closeButton.style.opacity = '1';
            closeButton.style.backgroundColor = 'rgba(0, 0, 0, 0.1)';
        });

        closeButton.addEventListener('mouseleave', () => {
            closeButton.style.opacity = '0.7';
            closeButton.style.backgroundColor = 'transparent';
        });

        notification.appendChild(iconElement);
        notification.appendChild(messageWrapper);
        notification.appendChild(closeButton);

        return notification;
    }

    getIcon(type) {
        const icons = {
            success: '✓',
            error: '✕',
            warning: '⚠',
            info: 'ℹ'
        };
        return icons[type] || icons.info;
    }

    remove(id) {
        const notification = this.notifications.get(id);
        if (!notification) return;

        notification.classList.add('notification-exit');
        notification.style.transform = 'translateX(100%)';
        notification.style.opacity = '0';

        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
            this.notifications.delete(id);
        }, 300);
    }

    clear() {
        this.notifications.forEach((notification, id) => {
            this.remove(id);
        });
    }

    limitNotifications() {
        if (this.notifications.size >= this.maxNotifications) {
            const oldestId = this.notifications.keys().next().value;
            this.remove(oldestId);
        }
    }

    generateId() {
        return Date.now().toString(36) + Math.random().toString(36).substr(2);
    }

    setupGlobalErrorHandling() {
        window.addEventListener('unhandledrejection', (event) => {
            this.show('An unexpected error occurred. Please try again.', 'error');
        });
    }

    success(message, duration) {
        return this.show(message, 'success', duration);
    }

    error(message, duration) {
        return this.show(message, 'error', duration);
    }

    warning(message, duration) {
        return this.show(message, 'warning', duration);
    }

    info(message, duration) {
        return this.show(message, 'info', duration);
    }
}

const style = document.createElement('style');
style.textContent = `
    .notification-show {
        transform: translateX(0) !important;
        opacity: 1 !important;
    }
`;
document.head.appendChild(style);

const notificationManager = new NotificationManager();
window.NotificationManager = notificationManager;

window.showNotification = (message, type, duration) => notificationManager.show(message, type, duration);
window.showSuccess = (message, duration) => notificationManager.success(message, duration);
window.showError = (message, duration) => notificationManager.error(message, duration);
window.showWarning = (message, duration) => notificationManager.warning(message, duration);
window.showInfo = (message, duration) => notificationManager.info(message, duration);
