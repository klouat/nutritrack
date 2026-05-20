const TOKEN_STORAGE_KEY = 'nutri_access_token';
const TOKEN_COOKIE_NAME = 'nutri_token';

const setCookie = (name, value, days = 30) => {
    const expires = new Date(Date.now() + days * 24 * 60 * 60 * 1000).toUTCString();
    document.cookie = `${name}=${encodeURIComponent(value)}; expires=${expires}; path=/; SameSite=Lax`;
};

const clearCookie = (name) => {
    document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/; SameSite=Lax`;
};

const getToken = () => window.localStorage.getItem(TOKEN_STORAGE_KEY);

const setToken = (token) => {
    if (!token) {
        return;
    }

    window.localStorage.setItem(TOKEN_STORAGE_KEY, token);
    setCookie(TOKEN_COOKIE_NAME, token);
};

const clearToken = () => {
    window.localStorage.removeItem(TOKEN_STORAGE_KEY);
    clearCookie(TOKEN_COOKIE_NAME);
};

const applyAuthHeader = () => {
    const token = getToken();

    if (token && window.axios) {
        window.axios.defaults.headers.common.Authorization = `Bearer ${token}`;
    } else if (window.axios) {
        delete window.axios.defaults.headers.common.Authorization;
    }
};

const logout = async () => {
    const token = getToken();

    try {
        await fetch('/api/logout', {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                ...(token ? { Authorization: `Bearer ${token}` } : {}),
            },
        });
    } catch (error) {
        console.error('Logout error:', error);
    } finally {
        clearToken();
        window.location.href = '/login';
    }
};

window.NutriAuth = {
    getToken,
    setToken,
    clearToken,
    applyAuthHeader,
    logout,
};

applyAuthHeader();
