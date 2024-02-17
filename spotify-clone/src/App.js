import logo from './logo.svg';
import './App.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import {Container, InputGroup, FormControl ,Button, Row, Card} from 'react-bootstrap';
import {useState, useEffect} from 'react';

function App() {
  const[searchInput,setSearchInput] = useState("");

  return (
    <body style={{backgroundColor: "#D3D3D3"}}>
    <div className="App"
    style = {{
      
    }}>
      <Container>
        <InputGroup className="mb-3" size="lg">
          <FormControl 
        
          placeholder="Search Music"
          type = "input"
          onKeyPress ={event=> { 
            if(event.key === "Enter"){
              console.log("Pressed Enter");
            }
          }}
          
          onChange={event=> setSearchInput(event.target.value)}
          />
          <Button onClick={()=>{console.log("Hello")}} style={{backgroundColor:"black"}}>
            Search
          </Button>
        </InputGroup>
      </Container>
      <Container>
        <Card>
          <Card.Img src="#" />
          <Card.Body>
            <Card.Title>Album Name</Card.Title>
          </Card.Body>
        </Card>
      </Container>
    </div>
    </body>
  );
}

export default App;
