import styled from 'styled-components';
import OptionSelector from './OptionSelector';
import options from '../options.json';

const MessagePartSelector = styled.div`
    width: 93.75vh;
    margin: 0 auto 45px;
    border-top: 2px solid #4D4941;
    border-bottom: 2px solid #4D4941;
    padding: 37px 0;
    text-align: center;
    font-size: 22px;
`;

const Button = styled.button`
    background: none;
    border: none;
    padding: 4px;
    line-height: 1;
    text-decoration: underline;
    cursor: pointer;

    & + & {
        margin-left: 12px;
    }

    &.active {
        background: #4D4941;
        color: #9C5448;
        text-decoration: none;
    }
`;

const ChooseMessage = () => (
    <div>
        <MessagePartSelector>
            &quot;
            <Button type="button" className="active">[A hollowed-out doll]</Button>
            <Button type="button">[fell with grace]</Button>
            <Button type="button">[during a pointless battle]</Button>
            .&quot;
        </MessagePartSelector>
        <OptionSelector options={options[1]} />
    </div>
);

export default ChooseMessage;
