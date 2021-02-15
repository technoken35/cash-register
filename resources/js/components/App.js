import React, { useEffect, useState } from "react";
import TransactionForm from "./TransactionForm";
import ChangeCount from "./ChangeCount";
import cashRegister from "../apis/cashRegister";

const App = () => {
    const validate = () => {
        const numberRegex = /^[0-9]+$/;
        if (numberRegex.test && state.amountOwed && state.amountPaid) {
            setState({
                ...state,
                errorMsg: "",
            });
            if (state.amountPaid < state.amountOwed) {
                setState({
                    ...state,
                    errorMsg: "Amount paid must be more than amount owed",
                });
            }
        } else {
            setState({
                ...state,
                errorMsg: "You must enter a number",
            });
        }
    };

    const bills = [1, 5, 10, 20, 50, 100];
    const coins = [1, 5, 10, 25];

    const onSubmit = () => {
        // split into two variables after .
    };

    const handleChange = (e) => {
        console.log(e.target.value);
        setState({
            ...state,
            [`${e.target.name}`]: e.target.value,
        });
    };

    const [state, setState] = useState({
        amountOwed: 0,
        amountPaid: 0,
        validatedInput: false,
        loading: false,
        errorMsg: "",
    });

    const fetchTransaction = async () => {
        const res = await cashRegister.get("/transaction");
        setState({
            ...state,
            amountOwed: res.data.transaction[0].amount_owed,
            amountPaid: res.data.transaction[0].amount_paid,
            loading: false,
        });
    };

    useEffect(() => {
        fetchTransaction();
        setState({
            ...state,
            loading: true,
        });
    }, []);

    return (
        <div className="container p-5">
            <h1 className="text-center">Cash Register</h1>
            <TransactionForm
                amountOwed={state.amountOwed}
                amountPaid={state.amountPaid}
                handleChange={handleChange}
                onSubmit={onSubmit}
                validate={validate}
                errorMsg={state.errorMsg}
            />
            <ChangeCount />
        </div>
    );
};

export default App;
