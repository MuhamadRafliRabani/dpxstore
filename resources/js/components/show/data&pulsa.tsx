import { handleSetData } from '@/lib/insertDataUser';
import { inputOrder } from '@/types';
import { BadgeInfo } from 'lucide-react';
import { Input } from '../ui/input';
import { Label } from '../ui/label';

const InputDatapulsa = ({ data, setData, errors }: inputOrder) => {
    return (
        <>
            <div className="flex w-full flex-col items-start justify-center gap-2 md:gap-4">
                <Label className="text-primary">No Handphone</Label>

                <div className="flex w-full gap-2">
                    <Input disabled type="text" placeholder="+62" className="text-primary placeholder:text-primary w-[50px] text-center" />
                    <Input
                        id="no handphone"
                        placeholder="812xxxxxxx"
                        inputMode="numeric"
                        pattern="\d*"
                        value={data.no_handphone}
                        onChange={(e) => handleSetData(setData, e, 'no_handphone')}
                        className="text-primary placeholder:text-primary/70 w-full flex-1 text-sm sm:text-base md:text-sm"
                    />

                    {errors.no_handphone && <p className="text-sm text-red-500">Isi no handphone kamu dengan benar</p>}
                </div>
            </div>

            <p className="text-primary/70 bg-accent/10 flex w-full gap-1 rounded-sm p-1 text-xs sm:text-sm md:text-xs">
                <span>
                    <BadgeInfo className="size-4" />
                </span>{' '}
                Pleas make sure you fill the correct account data.
            </p>
        </>
    );
};

export default InputDatapulsa;
