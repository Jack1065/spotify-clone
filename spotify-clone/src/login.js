import 'bootstrap/dist/css/bootstrap.min.css';
import React from 'react';
import './login.css';
import {InputGroup,Button,} from 'react-bootstrap';

export function Login() {
    return(
      <div className="login-wrapper">
        <h1>Please Log In</h1>
        <form>
          <label>
            <p>Username</p>
            <input type="text" />
          </label>
          <label>
            <p>Password</p>
            <input type="password" />
          </label>
          <div>
            <Button type="submit">Submit</Button>
          </div>
        </form>
      </div>
    )
  }