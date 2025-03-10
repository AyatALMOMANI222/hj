import './bootstrap';
import React from 'react';
import ReactDOM from 'react-dom/client';
import RegisterForm from './RegisterForm';

// مكون React بسيط
const App = () => {
    return (
        <div>

            <Router>
                <Routes>
                    {/* المسار لصفحة التسجيل */}
                </Routes>                    <Route path="/register" element={<RegisterForm />} />

            </Router>
        </div>
    );
};

// اختار العنصر الذي ستقوم بإدراج React فيه
const root = ReactDOM.createRoot(document.getElementById('app'));
root.render(<App />);
