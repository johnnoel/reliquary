import OptionSelector from './OptionSelector';
import { useState } from 'preact/hooks';
import classNames from 'classnames';
import options from '../options';
import { User } from '../types';
import Api from '../api';
import Information from './Information';

const ChooseMessage = ({ user }: ChooseMessageProps) => {
    const [ active, setActive ] = useState<number|null>(null);
    const [ selected, setSelected ] = useState<string[]>([]);
    const [ info, setInfo ] = useState<string>('Choose a phrase to input.');
    const [ canSubmit, setCanSubmit ] = useState<boolean>(false);

    // todo better / smarter replacement than this
    options[0].username = user.name;

    const onOptionSelect = async (sel: string) => {
        if (active === null) {
            return;
        }

        const newSelected = selected.slice(0);
        newSelected[active] = sel;
        setSelected(newSelected);
        setActive(null);
        setCanSubmit(false);

        if (isFullMessage(newSelected)) {
            const isAvailable = await Api.isMessageAvailable(newSelected[0], newSelected[1], newSelected[2]);
            setInfo((isAvailable) ? 'Message available.' : 'Message not available.');
            setCanSubmit(isAvailable);
        }
    };

    return <>
        <div className="choosemessage-container">
            <div className="choosemessage-partselector">
                {[0, 1, 2].map(idx => (
                    <button type="button" className={classNames('choosemessage-btn', { 'active': active === idx })} onClick={() => setActive(idx)}><span>[{getOption(idx, selected[idx])}]</span></button>
                ))}
            </div>

            {(active !== null) ? <OptionSelector options={options[active]} selected={selected[active]} onSelect={onOptionSelect} /> : null}

            <div className="btnlist">
                <button type="button" className="btn" onClick={() => onConfirm(selected, user)} disabled={!canSubmit}><i/>Confirm</button>
                <a href="/logout" className="btn"><i/>Logout</a>
            </div>
        </div>

        <Information text={info} />
    </>
}

const onConfirm = async (selected: string[], user: User): Promise<void> => {
    try {
        await Api.chooseMessage(selected[0], selected[1], selected[2]);
        window.location.href = '/' + user.id;
    } catch (e) {
        console.error(e);
        alert(e);
    }
};

const getOption = (optionSet: number, selected: string|undefined): string => {
    if (selected === undefined || options[optionSet][selected] === undefined) {
        return 'Please select...';
    }

    return options[optionSet][selected];
};

const isFullMessage = (selected: string[]): boolean => {
    return selected.filter(s => s !== undefined).length === 3;
}

interface ChooseMessageProps {
    user: User;
}

export default ChooseMessage;
