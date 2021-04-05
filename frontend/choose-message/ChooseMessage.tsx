import OptionSelector from './OptionSelector';
import { useState } from 'preact/hooks';
import classNames from 'classnames';
import options from '../options';

const ChooseMessage = () => {
    const [ active, setActive ] = useState<number|null>(null);
    const [ selected, setSelected ] = useState<string[]>([]);

    return <div>
        <div className="choosemessage-partselector">
            &quot;
            <button type="button" className={classNames('choosemessage-btn', { 'active': active === 0 })} onClick={() => setActive(0)}>[{getOption(0, selected[0])}]</button>
            <button type="button" className={classNames('choosemessage-btn', { 'active': active === 1 })} onClick={() => setActive(1)}>[{getOption(1, selected[1])}]</button>
            <button type="button" className={classNames('choosemessage-btn', { 'active': active === 2 })} onClick={() => setActive(2)}>[{getOption(2, selected[2])}]</button>
            .&quot;
        </div>

        {(active !== null) ? <OptionSelector options={options[active]} selected={selected[active]} onSelect={(sel) => {
            const newSelected = selected.slice(0);
            newSelected[active] = sel;
            setSelected(newSelected);
        }} /> : null}

        <button type="button" className="btn" onClick={() => onConfirm(selected)}>Confirm</button>
    </div>
}

const onConfirm = (selected: string[]): void => {
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

        // todo get twitter ID from source page or return URL from create task?
        const twitterId = '104439298';
        window.location.href = '/' + twitterId;
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

export default ChooseMessage;
