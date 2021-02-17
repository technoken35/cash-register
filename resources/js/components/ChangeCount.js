import React from "react";

const ChangeCount = (props) => {
    console.log(props, "change component");

    if (props.showCount) {
        const p = props.cashInfo.cash_count;
        console.log(p[1], "pennies ");

        if (props.type === "coin") {
            return (
                <div className="card mb-4">
                    <div className="card-body">
                        <h5 className="card-title">Coin Count</h5>
                        <h6
                            style={{ color: "green" }}
                            className="card-subtitle mb-2"
                        >{`Min coins needed: ${props.cashInfo.min_cash} Coins Due: ${props.cashInfo.cash_back}`}</h6>
                        <ul className="list-group">
                            <li className="list-group-item">{`pennies: ${p["1"]}`}</li>
                            <li className="list-group-item">{`nickels: ${p["5"]}`}</li>
                            <li className="list-group-item">{`dimes: ${p["10"]}`}</li>
                            <li className="list-group-item">{`quarters: ${p["25"]}`}</li>
                        </ul>
                    </div>
                </div>
            );
        } else {
            return (
                <div className="card mb-4">
                    <div className="card-body">
                        <h5 className="card-title">Cash Count</h5>
                        <h6
                            style={{ color: "green" }}
                            className="card-subtitle mb-2"
                        >{`Min bills needed: ${props.cashInfo.min_cash} Cash Due: ${props.cashInfo.cash_back}`}</h6>
                        <ul className="list-group">
                            <li className="list-group-item">{`dollars: ${p["1"]}`}</li>
                            <li className="list-group-item">{`fives: ${p["5"]}`}</li>
                            <li className="list-group-item">{`tens: ${p["10"]}`}</li>
                            <li className="list-group-item">{`twenties: ${p["20"]}`}</li>
                            <li className="list-group-item">{`fifties: ${p["50"]}`}</li>
                            <li className="list-group-item">{`hundreds: ${p["100"]}`}</li>
                        </ul>
                    </div>
                </div>
            );
        }
    } else {
        return <></>;
    }
};

export default ChangeCount;
