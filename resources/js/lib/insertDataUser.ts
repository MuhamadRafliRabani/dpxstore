import { ChangeEvent } from 'react';

export const handleSetData = (setData: (key: string, value: string) => void, e: ChangeEvent<HTMLInputElement>, key: string) => {
    const onlyDigits = e.target.value.replace(/[^0-9]/g, '');
    setData(key, onlyDigits);
};
