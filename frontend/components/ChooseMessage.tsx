import OptionSelector from './OptionSelector';
import { useState } from 'preact/hooks';
import classNames from 'classnames';
import options from '../options';
import { User } from '../types';
import Information from './Information';

const ChooseMessage = ({ user }: ChooseMessageProps) => {
    const [ active, setActive ] = useState<number|null>(null);
    const [ selected, setSelected ] = useState<string[]>([]);
    const [ info, setInfo ] = useState<string>('Choose a phrase to input.');

    // todo better / smarter replacement than this
    options[0].username = user.name;

    return <>
        <div className="choosemessage-container">
            <div className="choosemessage-partselector">
                <button type="button" className={classNames('choosemessage-btn', { 'active': active === 0 })} onClick={() => setActive(0)}>[<span>{getOption(0, selected[0])}</span>]</button>
                <button type="button" className={classNames('choosemessage-btn', { 'active': active === 1 })} onClick={() => setActive(1)}>[<span>{getOption(1, selected[1])}</span>]</button>
                <button type="button" className={classNames('choosemessage-btn', { 'active': active === 2 })} onClick={() => setActive(2)}>[<span>{getOption(2, selected[2])}</span>]</button>
            </div>

            {(active !== null) ? <OptionSelector options={options[active]} selected={selected[active]} onSelect={(sel) => {
                const newSelected = selected.slice(0);
                newSelected[active] = sel;
                setSelected(newSelected);
                setActive(null);

                if (newSelected.filter(s => s !== undefined).length < 3) {
                    return;
                }

                fetch('/is-message-available?p1=' + newSelected[0] + '&p2=' + newSelected[1] + '&p3=' + newSelected[2], {
                    method: 'GET',
                    credentials: 'same-origin',
                }).then(resp => {
                    if (resp.status === 404) {
                        setInfo('Message available.');
                    } else {
                        setInfo('Message not available.');
                    }
                });
            }} /> : null}

            <div className="btnlist">
                <button type="button" className="btn" onClick={() => onConfirm(selected, user)}><i/>Confirm</button>
                <a href="/logout" className="btn"><i/>Logout</a>
            </div>
        </div>

        <Information text={info} />
    </>
}

const onConfirm = (selected: string[], user: User): void => {
    const fd = new FormData();
    fd.append('p1', selected[0]);
    fd.append('p2', selected[1]);
    fd.append('p3', selected[2]);

    // todo show loading indicator
    fetch('/choose-message.json', {
        method: 'POST',
        credentials: 'same-origin',
        body: fd,
    }).then(resp => {
        if (resp.status === 409) {
            // cannot create as already claimed
            throw 'Already claimed';
        } else if (resp.status !== 201) {
            // not created, not sure what's wrong
            throw 'Unknown error';
        }

        window.location.href = '/' + user.id;
    }).catch(reason => {
        alert(reason);
    })
};

const getOption = (optionSet: number, selected: string|undefined): string => {
    if (selected === undefined) {
        return 'Please select...';
    }

    const opts = options[optionSet];

    if (typeof opts[selected] === 'undefined') {
        return 'Please select...';
    }

    return opts[selected];
};

interface ChooseMessageProps {
    user: User;
}

export default ChooseMessage;
