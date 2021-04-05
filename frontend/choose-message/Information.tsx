
const Information = ({ text }: InformationProps) => (
    <div className="info">
        {text}
    </div>
);

interface InformationProps {
    text: string;
}

export default Information;
