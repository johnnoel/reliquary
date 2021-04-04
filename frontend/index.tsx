import { render } from 'preact';
import ChooseMessage from './choose-message/ChooseMessage';
import './app.scss';

const container = document.getElementById('app');
if (container !== null) {
    render(<ChooseMessage />, container);
}

