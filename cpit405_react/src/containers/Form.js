import './Form.css';
import Result from './Result';
import { useState, useEffect } from 'react';

const Form = () => {
    const [describtion, setDescribtion] = useState(null);
    const [script, setScript] = useState(null);
    const [file, setFile] = useState(null);
    const [fileSizeError, setFileSizeError] = useState(false);
    const [fileTypeError,setFiletypeError] = useState(false);

    useEffect(() => {
        if (script != null) {
            storeScript();
        }
    }, [script]);

    useEffect(() => {
        setScript(null);
    }, [describtion]);

    async function storeScript() {
        const myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/json");

        const raw = JSON.stringify({
            script: script,
            describtion: describtion,
        });

        const requestOptions = {
            method: "POST",
            headers: myHeaders,
            body: raw,
            redirect: "follow",
        };

        await fetch("http://localhost:3000/CPIT405_DB/api/create.php", requestOptions);
    }

    const handleFileChange = (e) => {
        const selectedFile = e.target.files[0];

        // Check if the file size is greater than 8MB
        if (selectedFile && selectedFile.size > 24 * 1024 * 1024) {
            setFileSizeError(true);
            e.target.value = null; // Clear the selected file
            return;
        } else {
            setFileSizeError(false);
        }

        // Check if the file type is audio
        const allowedAudioTypes = ['audio/mpeg', 'audio/wav', 'audio/mp3', 'audio/x-wav', 'audio/ogg'];
        if (!allowedAudioTypes.includes(selectedFile.type)) {

            setFiletypeError(true);
            e.target.value = null; // Clear the selected file
            return;
        }else{
            setFiletypeError(false);
        }

        setFile(selectedFile);
    };

    async function handleSubmit(e) {
        e.preventDefault();
        if (!file) {
            alert('Please select a file.');
            return;
        }

        const formData = new FormData();
        formData.append('file', file);

        // Return a script
        const response = await fetch('http://localhost:3000/CPIT405_DB/api/upload.php', {
            method: 'POST',
            body: formData,
        });
        const data = await response.json();
        console.log(data);
        setScript(data.text);
    }

    return (
        <>
            <form onSubmit={handleSubmit}>
                <div>
                    <label>Description:</label>
                    <input
                        type="text"
                        placeholder="type description"
                        onChange={(e) => setDescribtion(e.target.value)}
                    />
                </div>
                <div>
                    <label>Audio file:</label>
                    <input
                        type="file"
                        placeholder="enter the audio file"
                        onChange={handleFileChange}
                    />
                    {fileSizeError && (
                        <p className='file-error'>File size exceeds 25MB. Please choose a smaller file.</p>
                    )}
                    {fileTypeError && (
                        <p className='file-error'>Please select a valid audio file.</p>
                    )}
                </div>

                <button>Submit</button>
            </form>
            {script && (
                <div>
                    <Result script={script} describtion={describtion} />
                </div>
            )}
        </>
    );
};

export default Form;
