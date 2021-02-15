import React, { useEffect } from "react";
import TransactionForm from "./TransactionForm";

const App = () => {
    const changeDue = () => {
        return (
            <div>
                <p>I owe you plenty</p>
            </div>
        );
    };

    useEffect(() => {
        console.log("component mounted");
    }, []);

    return (
        <div className="container p-5">
            <h1 className="text-center">Cash Register</h1>
            <TransactionForm />
            {changeDue()}
        </div>
    );
};

export default App;
