import toPairs from 'lodash/toPairs';
import classNames from 'classnames';
import { OptionSet } from '../options';

const OptionSelector = ({ options, selected, onSelect }: OptionSelectorProps) => (
    <div className="optionselector-container">
        <div className="optionselector-modal">
            {toPairs(options).map(([ key, option ]) => (
                <div key={key} className={classNames('optionselector-option', { 'active': selected === key })} onClick={() => onSelect(key)}>{option}</div>
            ))}
        </div>
    </div>
);

interface OptionSelectorProps {
    options: OptionSet;
    selected: string|undefined;
    onSelect(selected: string): void;
}

export default OptionSelector;
