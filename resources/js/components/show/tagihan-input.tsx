import { handleSetData } from '@/lib/insertDataUser';
import { inputOrder } from '@/types';
import { Input } from '@headlessui/react';
import { BadgeInfo } from 'lucide-react';

const InputTagihan = ({ data, setData, errors }: inputOrder) => {
    return (
        <>
            <div className="grid grid-cols-1 gap-4 md:grid-cols-2">
                <Input
                    placeholder="Masukan No Akun Anda"
                    value={data.no_akun}
                    onChange={(e) => handleSetData(setData, e, 'no_akun')}
                    className="placeholder:text-primary text-primary text-sm sm:text-base md:text-sm"
                />
                {errors.zone_id && <p className="text-sm text-red-500">{errors.zone_id}</p>}
            </div>
            <p className="text-primary/70 text-xs sm:text-sm md:text-xs">
                <span>
                    <BadgeInfo className="size-4" />
                </span>{' '}
                Pleas make sure you fill the correct account data.
            </p>
        </>
    );
};

export default InputTagihan;
