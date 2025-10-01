import { ReactNode } from 'react';

interface props {
    children: ReactNode;
    title: string;
    number: number;
}

const InputWraper = (props: props) => {
    return (
        <div className="text-accent">
            <div className="bg-accent overflow-hidden rounded-md shadow-lg">
                <div className="header bg-primary-foreground text-accent-foreground flex items-center justify-start gap-4 text-xs">
                    {/* ganti jadi label */}
                    <div className="bg-accent text-accent-foreground px-4 py-2">
                        <span className="text-xxs shrink-0">{props.number}</span>
                    </div>
                    <h3>{props.title}</h3>
                </div>

                {props.children}
            </div>
        </div>
    );
};

export default InputWraper;
