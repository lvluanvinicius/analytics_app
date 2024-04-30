import "./global.css";

import React from "react";
import ReactDOM from "react-dom/client";

import { App } from "./src/app";

ReactDOM.createRoot(document.getElementById("root-frontend")!).render(
    <React.StrictMode>
        <App />
    </React.StrictMode>,
);
