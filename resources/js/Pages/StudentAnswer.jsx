import { Head, Link, useForm } from '@inertiajs/react';

export default function StudentAnswer({ invitation }) {
    const { data, setData, post, processing, errors } = useForm({
        answers: {},
        studentId:'',
        error: '',
    });

    const handleAnswerChange = (questionId, selectedOption) => {
        const updatedAnswers = { ...data.answers, [questionId]: selectedOption };
        const updatedData = { ...data, answers: updatedAnswers, studentId: invitation.user_id }; // Update studentId
        setData(updatedData);
    };


   const handleSubmit = (e) => {
    e.preventDefault();

    // Validate answers
    const allQuestionsAnswered = Object.keys(data.answers).length === invitation.questionnaire.questions.length;
    if (!allQuestionsAnswered) {
        setData('error', 'Please answer all questions.');
        return;
    }

    try {
        // Submit answers
        post(route('questionnaire.submit'));

        // Show success message
        alert('Answers submitted successfully!');

        // Reset answers and error
        setData('answers', {});
        setData('error', '');
    } catch (error) {
        console.error('Error submitting questionnaire:', error);
        setData('error', 'Failed to submit answers. Please try again later.');
        }
    };



    return (
        <>
            <Head title="Questionnaire" />
            <div className="bg-gray-50 dark:bg-black text-black dark:text-white min-h-screen flex flex-col items-center justify-center py-6">
                <div className="max-w-2xl px-6 lg:max-w-7xl">
                    <main className="mt-6">
                        <form onSubmit={handleSubmit} className="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                            <h2 className="text-xl font-semibold mb-4">{invitation.questionnaire.title}</h2>
                            {data.error && <p className="text-red-500 mb-4">{data.error}</p>}
                            {invitation.questionnaire.questions.map(question => (
                                <div key={question.id} className="mb-6">
                                    <h3 className="text-lg font-semibold mb-2">{question.subject.toUpperCase()}</h3>
                                    <div className="mb-4">
                                        <p className="mb-2">{question.question}</p>
                                        <ul className="space-y-2">
                                           {question.options.map((option, index) => (
                                            <li key={index}>
                                                <label className="inline-flex items-center">
                                                    <input
                                                        type="radio"
                                                        name={`question_${question.id}`}
                                                        value={option} // Use option as the value instead of index + 1
                                                        onChange={() => handleAnswerChange(question.id, option)} // Pass question ID and selected option
                                                        className="form-radio h-5 w-5 text-blue-600"
                                                    />
                                                    <span className="ml-2">{option}</span>
                                                </label>
                                            </li>
                                        ))}

                                        </ul>
                                    </div>
                                </div>
                            ))}
                            <button type="submit" className="bg-blue-500 text-white px-4 py-2 rounded-lg mt-4" disabled={processing}>
                                {processing ? 'Submitting...' : 'Submit'}
                            </button>
                        </form>
                    </main>
                </div>
            </div>
        </>
    );
}
