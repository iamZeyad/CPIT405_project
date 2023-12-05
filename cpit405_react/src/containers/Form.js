import './Form.css';
import Result from './Result';
import { useState, useEffect } from 'react';
const Form = () => {
    const [describtion, setDescribtion] = useState(null);
    const [script, setScript] = useState(null);
    const [file, setFile] = useState(null)

    useEffect(() => {
        if (script != null) {
            storeScript();
        }
    }, [script]);

    useEffect(() => {
        setScript(null)
    },[describtion]);


    function storeScript() {
        const myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/json");

        const raw = JSON.stringify({
            script: script,
            describtion: describtion
        });

        const requestOptions = {
            method: "POST",
            headers: myHeaders,
            body: raw,
            redirect: "follow",
        };

        fetch("http://localhost:3000/CPIT405_DB/api/create.php", requestOptions);
    }
    async function handleSubmit(e) {
        e.preventDefault();
        if (!file) {
            alert('Please select a file.');
            return;
        }

        const formData = new FormData();
        formData.append('file', file);

        //return a script
        const response = await fetch('http://localhost:3000/CPIT405_DB/api/upload.php', {
            method: 'POST',
            body: formData,
        })
        const data = await response.json();
        setScript(data.text);
    }

    return (
        <>

            <form onSubmit={handleSubmit}>
                <div>
                    <label>Description:</label>
                    <input type="text"
                        placeholder="type description"
                        onChange={(e) => { setDescribtion(e.target.value) }} />
                </div>
                <div>
                    <label>MP3 file:</label>
                    <input type="file"
                        placeholder="enter the audio file"
                        onChange={(e) => { setFile(e.target.files[0]) }} />
                </div>

                <button>submit</button>
            </form>
            {script &&
                <div>
                    <Result script={script} describtion={describtion} />
                </div>}
        </>

    )
}
export default Form;