import React, { useState } from 'react';
import axios from 'axios';
import toastr from 'toastr';

const RegisterForm = () => {
    const [formData, setFormData] = useState({
        name: '',
        email: '',
        password: '',
        phone: '',
        whatsapp: '',
        address: '',
        role: '',
        age: '',
        testPreparation: false,
        profilePicture: null,
        // إضافة باقي الحقول هنا حسب الحاجة
    });

    const handleChange = (e) => {
        const { name, value, type, checked } = e.target;
        setFormData({
            ...formData,
            [name]: type === 'checkbox' ? checked : value,
        });
    };

    const handleFileChange = (e) => {
        setFormData({
            ...formData,
            profilePicture: e.target.files[0],
        });
    };

    const handleSubmit = (e) => {
        e.preventDefault();

        const form = new FormData();
        for (const key in formData) {
            form.append(key, formData[key]);
        }

        axios.post('/register', form)
            .then((response) => {
                toastr.success(response.data.message);
                console.log(response.data);
            })
            .catch((error) => {
                toastr.error(error.response.data.message);
                console.error(error);
            });
    };

    return (
        <div className="card p-4" style={{ width: '500px' }}>
            <h3 className="text-center text-primary mb-4">Create an Account</h3>
            <form onSubmit={handleSubmit}>
                <div className="mb-3">
                    <input
                        type="text"
                        name="name"
                        className="form-control"
                        placeholder="Enter your full name"
                        value={formData.name}
                        onChange={handleChange}
                        required
                    />
                </div>
                <div className="mb-3">
                    <input
                        type="email"
                        name="email"
                        className="form-control"
                        placeholder="Enter your email"
                        value={formData.email}
                        onChange={handleChange}
                        required
                    />
                </div>
                <div className="mb-3">
                    <input
                        type="password"
                        name="password"
                        className="form-control"
                        placeholder="Enter your password"
                        value={formData.password}
                        onChange={handleChange}
                        required
                        autoComplete="off"
                    />
                </div>
                <div className="mb-3">
                    <input
                        type="tel"
                        name="phone"
                        className="form-control"
                        placeholder="Enter your phone number"
                        value={formData.phone}
                        onChange={handleChange}
                        required
                    />
                </div>
                <div className="mb-3">
                    <input
                        type="tel"
                        name="whatsapp"
                        className="form-control"
                        placeholder="Enter your WhatsApp number"
                        value={formData.whatsapp}
                        onChange={handleChange}
                        required
                    />
                </div>
                <div className="mb-3">
                    <input
                        type="text"
                        name="address"
                        className="form-control"
                        placeholder="Enter your address"
                        value={formData.address}
                        onChange={handleChange}
                        required
                    />
                </div>
                <div className="mb-3">
                    <select
                        name="role"
                        className="form-select"
                        value={formData.role}
                        onChange={handleChange}
                        required
                    >
                        <option value="">Select Role</option>
                        <option value="trainee">Trainee</option>
                        <option value="instructor">Instructor</option>
                        <option value="training_center">Training Center</option>
                    </select>
                </div>

                {/* Dynamic Fields */}
                {/* يمكنك استخدام نفس المنطق لإظهار الحقول الديناميكية */}
                {/* لنشر مكونات خاصة بكل دور هنا */}

                <button type="submit" className="btn btn-primary w-100">
                    Register
                </button>
            </form>

            <p className="mt-3 text-center">
                Already have an account? <a href="/login" className="text-primary">Login</a>
            </p>
        </div>
    );
};

export default RegisterForm;
ReactDOM.render(<RegisterForm />, document.getElementById('app'));
