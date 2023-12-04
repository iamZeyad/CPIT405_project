import { useState, useEffect } from "react"

const Home = () => {
    const [describtion, setDescribtion] = useState(null);
    const [script, setScript] = useState(null);
    const [file, setFile] = useState(null)

    useEffect(() => {
        if(script != null){
        fetchF();
        }
      }, [script]);


      async function fetchF() {
        const myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    const raw = JSON.stringify({
      script: script,
      describtion:describtion
    });

    const requestOptions = {
      method: "POST",
      headers: myHeaders,
      body: raw,
      redirect: "follow",
    };

    const response = await fetch("http://localhost:3000/CPIT405_DB/api/create.php", requestOptions);
    const data = await response.json();
    console.log(data);
      }
async function handleClick(){
    if (!file) {
        alert('Please select a file.');
        return;
      }
  
      const formData = new FormData();
      formData.append('file', file);

    const response = await fetch('http://localhost:3000/CPIT405_DB/api/upload.php', {
        method: 'POST',
        body: formData,
      })
      const data = await response.json();
      console.log(data)
      setScript(data.text);
    }

    return(
        <>
        <input type="text" placeholder="type describtion" onChange={(e) => {setDescribtion(e.target.value)}}></input>
        <input type="file" placeholder="enter the audio file" onChange={(e) => {setFile(e.target.files[0])}}></input>

        <button onClick={handleClick}>create</button>
        <p>{script}</p>
        </>

    )
}
export default Home;