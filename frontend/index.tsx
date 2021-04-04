import { render } from 'preact';
import BodyReport from './body-report/BodyReport';
import ChooseMessage from './choose-message/ChooseMessage';
import './app.scss';

const container = document.getElementById('app');
if (container !== null) {
    //render(<BodyReport username="doot" message="A hollowed-out doll fell with grace during a pointless battle." />, container);
    render(<ChooseMessage />, container);
}
