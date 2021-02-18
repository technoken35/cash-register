import React, { useEffect, useState } from "react";
import TransactionForm from "./TransactionForm";
import ChangeCount from "./ChangeCount";
import cashRegister from "../apis/cashRegister";

const App = () => {
    const validate = () => {
        const numberRegex = /^[0-9]+$/;
        if (numberRegex.test && state.amountOwed && state.amountPaid) {
            if (Number(state.amountPaid) < Number(state.amountOwed)) {
                setState({
                    ...state,
                    errorMsg: "Amount paid must be more than amount owed",
                });
            } else {
                setState({
                    ...state,
                    errorMsg: "",
                });
            }
        } else {
            setState({
                ...state,
                errorMsg: "You must enter a number",
            });
        }
    };

    let cashInfo = {};
    let coinInfo = {};

    const onSubmit = async (e) => {
        e.preventDefault();
        const res = await cashRegister.post("/get-change", {
            transactionId: state.transactionId,
            amount_owed: state.amountOwed,
            amount_paid: state.amountPaid,
        });

        console.log(res.data);

        cashInfo = res.data.cash;
        coinInfo = res.data.coins;
        setState({
            ...state,
            showCount: true,
            amountOwed: `${res.data.amount_owed_cash}.${res.data.amount_owed_coins}`,
            amountPaid: `${res.data.amount_paid_cash}.${res.data.amount_paid_coins}`,
            cashInfo,
            coinInfo,
        });
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
        transactionId: null,
        validatedInput: false,
        showCount: false,
        test: {},
        loading: false,
        errorMsg: "",
        cashBack: "",
        cashInfo: {},
        coinInfo: {},
    });

    const fetchTransaction = async () => {
        const res = await cashRegister.get("/transaction");
        setState({
            ...state,
            amountOwed: `${res.data.transaction[0].amount_owed_cash}.${res.data.transaction[0].amount_owed_coins}`,
            amountPaid: `${res.data.transaction[0].amount_paid_cash}.${res.data.transaction[0].amount_paid_coins}`,
            transactionId: res.data.transaction[0].id,
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
            <div className="mb-5" id="form-wrapper">
                <TransactionForm
                    amountOwed={state.amountOwed}
                    amountPaid={state.amountPaid}
                    handleChange={handleChange}
                    onSubmit={onSubmit}
                    validate={validate}
                    errorMsg={state.errorMsg}
                />
            </div>

            <ChangeCount
                showCount={state.showCount}
                type={"cash"}
                cashInfo={state.cashInfo}
            />

            <ChangeCount
                showCount={state.showCount}
                type={"coin"}
                cashInfo={state.coinInfo}
            />
        </div>
    );
};

export default App;
