import styled from 'styled-components';

const Container = styled.div`
    width: 43vh;
    height: 517px;
    margin: 0 auto;
    border-left: 13px solid #A9A48B;
    position: relative;
    padding-left: 52px;

    &:before {
        content: '';
        display: block;
        position: absolute;
        left: 7px;
        top: 0;
        width: 4px;
        height: 100%;
        background: #A9A48B;
    }
`;

const Modal = styled.div`
    background: #D6D3B9;
    position: absolute;
    left: 52px;
    top: 0;
    height: 100%;
    overflow-y: scroll;
    scrollbar-color: #4D4941 #D6D3B9;
`;

const Option = styled.div`
    font-size: 22px;
    padding: 12px 0 12px 20px;

    & + & {
        margin-top: 35px;
    }
`;

const OptionSelector = ({ options }: OptionSelectorProps) => (
    <Container>
        <Modal>
            {options.map(option => (
                <Option>{option}</Option>
            ))}
        </Modal>
    </Container>
);

interface OptionSelectorProps {
    options: string[];
}

export default OptionSelector;
