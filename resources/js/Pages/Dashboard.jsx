import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';
import { useState } from 'react';

export default function Dashboard({ auth, activeQuestionnaries }) {
    const [questionnaires, setQuestionnaires] = useState([]);
    const { data: formData, setData: setFormData, post, errors } = useForm();

    const handleInputChange = (event) => {
        const { name, value } = event.target;
        setFormData(name, value);
    };

    const validateForm = () => {
        const errors = {};
        if (!formData.title.trim()) {
            errors.title = 'Title is required';
        }
        if (!formData.expiryDate.trim()) {
            errors.expiryDate = 'Expiry Date is required';
        }
        return errors;
    };

    const handleGenerateQuestionnaire = (event) => {
        event.preventDefault();
        const errors = validateForm();
        if (Object.keys(errors).length === 0) {
            setQuestionnaires([...questionnaires, formData]);
            setFormData({ title: '', expiryDate: '' });
            post(route('submit.questionnaire'), { data: formData });
        }
    };

     const handleSendInvitation = (questionnaireId) => {
        const confirmation = window.confirm('Are you sure you want to send invitations?');
        if (confirmation) {
            setFormData({ questionnaireId });
            post(route('send.invitation',{ questionnaireId }),{ data: formData });
            alert('Invitations sent!');
        }
    };

    const groupedQuestions = activeQuestionnaries ? activeQuestionnaries.reduce((acc, questionnaire) => {
        questionnaire.questions.forEach(question => {
            if (!acc[question.subject]) {
                acc[question.subject] = [];
            }
            acc[question.subject].push({ questionnaire, question });
        });
        return acc;
    }, {}) : {};

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>}
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden d-flex shadow-sm sm:rounded-lg">
                        <div className="flex flex-wrap">
                            <div className="w-full md:w-1/2 p-4">
                                <form onSubmit={handleGenerateQuestionnaire}>
                                    <div className="mb-4">
                                        <label htmlFor="title" className="block text-gray-700 font-bold mb-2">Title</label>
                                        <input type="text" id="title" name="title" value={formData.title} onChange={handleInputChange} className={`border rounded-md px-3 py-2 w-full ${errors.title ? 'border-red-500' : ''}`} required />
                                        {errors.title && <p className="text-red-500 mt-1">{errors.title}</p>}
                                    </div>
                                    <div className="mb-4">
                                        <label htmlFor="expiryDate" className="block text-gray-700 font-bold mb-2">Expiry Date</label>
                                        <input type="date" id="expiryDate" name="expiryDate" value={formData.expiryDate} onChange={handleInputChange} className={`border rounded-md px-3 py-2 ${errors.expiryDate ? 'border-red-500' : ''}`} required />
                                        {errors.expiryDate && <p className="text-red-500 mt-1">{errors.expiryDate}</p>}
                                    </div>
                                    <button type="submit" className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Generate</button>
                                </form>
                            </div>
                            <div className="w-full md:w-1/2 p-4">
                               <div className="mt-8">
                                    <h3 className="text-lg font-semibold mb-4">Active Questionnaires</h3>
                                    {activeQuestionnaries.map((questionnaire) => (
                                        <div key={questionnaire.id} className="border rounded-md p-4 mb-4">
                                            <p className="font-semibold">Questionnaire Title: {questionnaire.title}</p>
                                            <p className="text-red-500"><b>Expiry Date: {questionnaire.expiry_date}</b></p>
                                            {questionnaire.questions.map((question, index) => (
                                                <div key={question.id} className="border rounded-md p-4 my-2">
                                                    <p className="font-semibold">Question: {question.question}</p>
                                                    <p>Correct Answer: {question.options[question.correct_answer - 1]}</p>
                                                    <ul>
                                                        {question.options.map((option, index) => (
                                                            <li key={index}>{option}</li>
                                                        ))}
                                                    </ul>
                                                </div>
                                            ))}
                                            <button onClick={() => handleSendInvitation(questionnaire.id)} className="inline-block bg-green-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded-sm text-xs">
                                                Send Invitation to All Students
                                            </button>
                                        </div>
                                    ))}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
