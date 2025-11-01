import { handleSetData } from '@/lib/insertDataUser';
import { inputOrder } from '@/types';
import { Input } from '@headlessui/react';
import { Label } from '../ui/label';

const InputTagihan = ({ data, setData, errors }: inputOrder) => {
    return (
        <div className="flex w-full flex-col items-start justify-center gap-2 md:gap-4">
            <Label className="text-primary text-xs">No Akun</Label>

            <div className="w-full">
                <Input
                    id="no_akun"
                    placeholder="masukan no akun"
                    inputMode="numeric"
                    pattern="\d*"
                    value={data.no_akun}
                    onChange={(e) => handleSetData(setData, e, 'no_akun')}
                    className="text-accent-foreground/70 text-xxs bg-accent-foreground/10 flex-1"
                />
                {errors.no_akun && <p className="text-sm text-red-500">Isi no handphone kamu dengan benar</p>}
            </div>
        </div>
    );
};

export default InputTagihan;
