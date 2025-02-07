import { cn } from "@/lib/utils";

export function RxStatus({ value }: { value: number }) {
    const classColor = function () {
        if (value == 0) {
            return "bg-red-700";
        }

        if (value < -29) {
            return "bg-red-700";
        }

        if (value <= -29) {
            return "bg-orange-700";
        }

        if (value > -29 && value <= -27) {
            return "bg-orange-700";
        }

        if (value > -27 && value <= -25) {
            return "bg-green-900";
        }

        return "bg-green-500";
    };

    return (
        <div
            className={cn(
                "w-28 py-1 flex items-center justify-center rounded-md",
                classColor()
            )}
        >
            {value}
        </div>
    );
}
