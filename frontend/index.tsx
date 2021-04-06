import { render } from 'preact';
import { User } from './types';
import ChooseMessage from './components/ChooseMessage';
import './scss/app.scss';

declare global {
    interface Window {
        __LOGGED_IN_USER__: User;
        __EXISTING_MESSAGE__: string[];
    }
}

const user: User = window.__LOGGED_IN_USER__;
const message: string[] = window.__EXISTING_MESSAGE__;

const container = document.getElementById('app');
if (container !== null) {
    render(<ChooseMessage user={user} message={message} />, container);
}

