import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';
import AdminApp from './AdminApp';

const adminRoot = document.getElementById('admin-root');

if (adminRoot) {
    createRoot(adminRoot).render(
        React.createElement(
            React.StrictMode,
            null,
            React.createElement(AdminApp),
        ),
    );
}
