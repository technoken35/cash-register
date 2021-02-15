import React from "react";

const TransactionForm = () => {
    return (
        <div>
            <form>
                <div className="mb-3">
                    <label>Enter Amount Owed</label>
                    <input
                        id="amountOwed"
                        className="form-control"
                        type="number"
                        step="0.01"
                    ></input>
                </div>
                <div className="mb-3">
                    <label>Enter Amount Paid</label>
                    <input
                        id="amountPaid"
                        className="form-control"
                        type="number"
                        step="0.01"
                    ></input>
                </div>
                <button type="submit" className="btn btn-primary">
                    Submit
                </button>
            </form>
        </div>
    );
};

export default TransactionForm;
