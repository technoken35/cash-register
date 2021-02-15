import React from "react";

const TransactionForm = (props) => {
    return (
        <div>
            <form>
                <div className="mb-3">
                    <label>Enter Amount Owed</label>
                    <input
                        id="amountOwed"
                        name="amountOwed"
                        className="form-control"
                        type="number"
                        // step="0.01"
                        onChange={props.handleChange}
                        value={props.amountOwed}
                        onBlur={props.validate}
                    ></input>
                </div>
                <div className="mb-3">
                    <label>Enter Amount Paid</label>
                    <input
                        id="amountPaid"
                        name="amountPaid"
                        className="form-control"
                        type="number"
                        //  step="0.01"
                        onChange={props.handleChange}
                        value={props.amountPaid}
                        onBlur={props.validate}
                    ></input>
                </div>

                {props.errorMsg ? (
                    <p style={{ color: "red" }}>{props.errorMsg}</p>
                ) : (
                    <button type="submit" className="btn btn-primary">
                        Submit
                    </button>
                )}
            </form>
        </div>
    );
};

export default TransactionForm;
