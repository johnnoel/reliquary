import styled from 'styled-components';

// todo:
// 1. on page position (from top) of first block
// 2. chevron / indicator for active button

const Container = styled.div`
    border: 2px solid #D6D3B9;
    padding: 26px 62px 80px;
    text-align: center;
    width: 65vw;
    margin: 0 auto 120px;
`

const Title = styled.h1`
    margin: 0 0 24px;
    line-height: 1;
    font-size: 28px;
`;

const Username = styled.h2`
    margin: 0 0 21px;
    line-height: 1;
    font-size: 18px;
`;

const Divider = styled.hr`
    border: none;
    border-top: 2px solid #D6D3B9;
    margin: 0 0 90px;
`;

const Message = styled.p`
    font-size: 22px;
`;

const ButtonList = styled.div`
    border-left: 14px solid #B0AC97;
    padding-left: 54px;
    position: relative;
    width: 30vw;
    margin: 0 auto;

    &:before {
        content: '';
        position: absolute;
        left: 7px;
        top: 0;
        width: 4px;
        height: 100%;
        background: #B0AC97;
    }
`;

const Button = styled.button`
    display: block;
    width: 100%;
    border: none;
    color: #4D4941;
    background: #B0AC99;
    padding: 12px 11px 12px 47px;
    position: relative;
    cursor: pointer;
    text-align: left;
    font-size: 24px;
    line-height: 1;

    &:before {
        content: '';
        position: absolute;
        top: 12px;
        left: 11px;
        width: 24px;
        height: 24px;
        background: #4D4941;
    }

    & + & {
        margin-top: 24px;
    }

    &.active {
        background: #4D4941;
        color: #B0AC97;

        &:before {
            background: #B0AC97;
        }

        &:after {
            content: '';
            display: block;
            position: absolute;
            left: 0;
            top: -7px;
            border-top: 2px solid #4D4941;
            border-bottom: 2px solid #4D4941;
            width: 100%;
            height: calc(100% + 10px);
        }
    }
`;

const BodyReport = ({ message, username }: BodyReportProps) => (
    <div>
        <Container>
            <Title>Body Report</Title>
            <Username>{username}</Username>
            <Divider />
            <Message>{message}</Message>
        </Container>
        <div>
            <ButtonList>
                <Button type="button" className="active">Change Message</Button>
                <Button type="button">Claim Your Own Message</Button>
            </ButtonList>
        </div>
    </div>
);

interface BodyReportProps {
    message: string;
    username: string;
}

export default BodyReport;
