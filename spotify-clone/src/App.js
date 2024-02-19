import logo from './logo.svg';
import './App.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import {Container,Dropdown, InputGroup, FormControl ,Button, Row, Card} from 'react-bootstrap';
import {useState, useEffect} from 'react';
import{ Sidebar, Menu, MenuItem, SubMenu } from 'react-pro-sidebar';

const Client_ID = "436f5cf1d4cf4baf97032eab63f67562";
const Client_Secret = "ec6eafaac5d64c188c42c5b7537ba91b";


function App() {
  const[searchInput,setSearchInput] = useState("");
  const[acessToken, setAcessToken] = useState("");

useEffect(() => {
//Spotify API Access
  var auth = {
    method: 'POST',
    headers:{
      'Content-type': 'application/x-www-form-urlencoded'
    },
    body: 'grant_type=client_credentials&client_id='+Client_ID+'&client_secret='+Client_Secret

  }
 fetch('https://accounts.spotify.com/api/token', auth)
    .then(result => result.json())
    .then(data=> console.log(data))

}, []);

async function search(){
  console.log("Search for " + searchInput);

  var artistParam={
    method: 'GET',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': 'Bearer ' +acessToken
    }
  }
  var artistID = await fetch('https://api.spotify.com/v1/search?q=', artistParam)
    .then(result => result.json())
    .then(data=> console.log(data))

}

  return (
   
    <div className="App"
    style = {{
      backgroundColor: '#006699',
    }}>
      <Container>

      <Sidebar>
  <Menu>
    <SubMenu label="Charts">
      <MenuItem> Favorites</MenuItem>
      <MenuItem></MenuItem>
    </SubMenu>
    <MenuItem> </MenuItem>
    <MenuItem> Calendar </MenuItem>
  </Menu>
</Sidebar>;

        <InputGroup className="mb-3" size="lg" style ={{width:'50%', marginLeft:'auto', marginRight:'auto'}} >
          <FormControl 
        
          placeholder="Search Music"
          type = "input"
          onKeyPress ={event=> { 
            if(event.key === "Enter"){
              search(event.target.value);
            }
          }}
          
          onChange={event=> setSearchInput(event.target.value)}
          />
          <Button className='but' onClick={()=>{console.log("Hello")}} style={{backgroundColor:"black"}}>
            Search
          </Button>
        </InputGroup>
        </Container>
        <Container>
          <Row className="mx-2 row row-cols-4">
          <Card>
            <Card.Img src="#" />
            <Card.Body>
              <Card.Title>Album Name</Card.Title>
              <Button onClick={()=>{console.log("hello")}}>Info</Button>
            </Card.Body>
          </Card>
          <Card>
          <Card.Img src="#" />
          <Card.Body>
            <Card.Title>Album Name</Card.Title>
          </Card.Body>
        </Card>
        <Card>
          <Card.Img src="#" />
          <Card.Body>
            <Card.Title>Album Name</Card.Title>
          </Card.Body>
        </Card>
        <Card>
          <Card.Img src="#" />
          <Card.Body>
            <Card.Title>Album Name</Card.Title>
          </Card.Body>
        </Card>
          </Row>
        </Container>
      </div>
  
  );
}

export default App;
