import React, { useState, useEffect } from 'react';
import Navbar from './components/Navbar';
import HomePage from './components/HomePage';
import LoginPage from './components/LoginPage';
import RegisterPage from './components/RegisterPage';
import AddLinkPage from './components/AddLinkPage';
import MyLinksPage from './components/MyLinksPage';
import ViewLinkPage from './components/ViewLinkPage';
import EditLinkPage from './components/EditLinkPage';
import { getCurrentUser, logout } from './utils/db';

function App() {
    const [currentPage, setCurrentPage] = useState('home');
    const [selectedLinkId, setSelectedLinkId] = useState(null);
    const [user, setUser] = useState(getCurrentUser());

    const navigate = (page, param = null) => {
        setCurrentPage(page);
        if (param) setSelectedLinkId(param);
        else setSelectedLinkId(null);
    };

    const handleLogout = () => {
        logout();
        setUser(null);
        navigate('home');
    };

    const handleLogin = (userData) => {
        setUser(userData);
        navigate('home');
    };

    return (
        <div className="app">
            <Navbar user={user} onNavigate={navigate} onLogout={handleLogout} />
            <div className="main-content">
                {currentPage === 'home' && <HomePage onNavigate={navigate} />}
                {currentPage === 'login' && <LoginPage onNavigate={navigate} onLogin={handleLogin} />}
                {currentPage === 'register' && <RegisterPage onNavigate={navigate} onLogin={handleLogin} />}
                {currentPage === 'add' && <AddLinkPage onNavigate={navigate} user={user} />}
                {currentPage === 'myLinks' && <MyLinksPage onNavigate={navigate} user={user} />}
                {currentPage === 'view' && <ViewLinkPage linkId={selectedLinkId} onNavigate={navigate} />}
                {currentPage === 'edit' && <EditLinkPage linkId={selectedLinkId} user={user} onNavigate={navigate} />}
            </div>
        </div>
    );
}

export default App;