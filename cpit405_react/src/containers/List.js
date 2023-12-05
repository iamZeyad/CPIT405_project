import React, { useState, useEffect } from 'react';
import './List.css';

const ScriptList = () => {
    const [scripts, setScripts] = useState([]);

    useEffect(() => {
        // Fetch the scripts from the backend
        fetchScripts();
    }, []);

    const fetchScripts = async () => {
        const response = await fetch('http://localhost:3000/CPIT405_DB/api/readAll.php');
        const data = await response.json();
        if (Array.isArray(data)) {
            setScripts(data);
        } else {
            console.error('Received non-array response:', data);
            setScripts([]);  // Set to an empty array if the response is not an array
        }
    };
    

    const handleDelete = async (scriptId) => {
        const requestOptions = {
            method: 'DELETE', // or 'DELETE', if your server supports DELETE with body
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: scriptId }),
        };
        // Call Delete API
        await fetch(`http://localhost:3000/CPIT405_DB/api/delete.php`, requestOptions);
        // After deletion, fetch the updated list of scripts
        fetchScripts();
    };

    return (
        <div className="script-list-container">
            {scripts.length === 0 ? (
            <p>No scripts available.</p>
        ) : (
            scripts.map((script) => (
                <div key={script.id} className="script-item">
                    <div className="script-header">
                        <p className="script-description">{script.describtion}</p>
                        <p className="date-added">{script.date_added}</p>
                    </div>
                    <div className="script-text-box">
                        <p className="script-text">{script.script}</p>
                    </div>
                    <button onClick={() => handleDelete(script.id)} className="delete-btn">
                        Delete
                    </button>
                </div>
            ))
            )}
        </div>
    );
};

export default ScriptList;
