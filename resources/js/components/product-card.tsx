import { formatPrice } from '@/lib/price-format';
import { ReactNode } from 'react';
import { Card, CardContent, CardFooter } from './ui/card';
import Flazz from './ui/flazz';

export default function ProductCard({
    title,
    price,
    selected,
    onClick,
    icon,
}: {
    title: string;
    price: number;
    onClick: () => void;
    selected?: boolean;
    icon?: ReactNode | null;
}) {
    return (
        <Card
            className={`bg-accent-foreground/10 ccursor-pointer relative h-full overflow-hidden rounded-md p-0 shadow-2xl transition hover:shadow-md ${
                selected ? 'border-primary border-2 shadow-none' : 'border-none'
            }`}
            onClick={onClick}
        >
            <div className="flex h-full flex-col justify-between">
                <CardContent className="flex flex-col justify-center space-y-1.5 px-4 py-2">
                    {/* Title */}
                    <p className="popout text-primary text-xs font-semibold">{title}</p>

                    <div className="text-primary flex items-center gap-2">
                        {icon}
                        <p className="popout text-xxs font-bold whitespace-nowrap">{formatPrice(price)}</p>
                    </div>
                </CardContent>

                <CardFooter className="to-chart-2 flex items-end justify-end bg-gradient-to-b from-[#75E6DA] p-2">
                    <div className="bg-accent-foreground/90 rounded p-1">
                        <Flazz />
                    </div>
                </CardFooter>
            </div>
        </Card>
    );
}
