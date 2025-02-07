import { cn } from "@/lib/utils";

export function TxStatus({ value }: { value: number }) {
    const classColor = function () {
        if (value == 0) {
            return "bg-red-700";
        }

        if (value > 4) {
            return "bg-red-700";
        }

        if (value >= 3 && value <= 4) {
            return "bg-orange-700";
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
