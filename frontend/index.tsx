import { render } from 'preact';
import { User } from './types';
import ChooseMessage from './components/ChooseMessage';
import './scss/app.scss';

declare global {
    interface Window {
        __LOGGED_IN_USER__: User;
    }
}

const user: User = window.__LOGGED_IN_USER__;

const container = document.getElementById('app');
if (container !== null) {
    render(<ChooseMessage user={user} />, container);
}

