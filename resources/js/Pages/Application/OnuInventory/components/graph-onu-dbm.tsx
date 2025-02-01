"use client";

import {
    Area,
    AreaChart,
    CartesianGrid,
    XAxis,
    ResponsiveContainer,
} from "recharts";
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
    CardFooter,
} from "@/components/ui/card";
import {
    ChartConfig,
    ChartContainer,
    ChartLegend,
    ChartLegendContent,
    ChartTooltip,
    ChartTooltipContent,
} from "@/components/ui/chart";

const collections = [
    { COLLECTION_DATE: "01/02/2025 05:00:20", RXDBM: 186, TXDBM: 80 },
    { COLLECTION_DATE: "01/02/2025 07:00:20", RXDBM: 305, TXDBM: 200 },
    { COLLECTION_DATE: "01/02/2025 08:00:20", RXDBM: 237, TXDBM: 120 },
    { COLLECTION_DATE: "01/02/2025 09:00:20", RXDBM: 73, TXDBM: 190 },
    { COLLECTION_DATE: "01/02/2025 10:00:20", RXDBM: 209, TXDBM: 130 },
    { COLLECTION_DATE: "01/02/2025 11:00:20", RXDBM: 214, TXDBM: 140 },
];

const chartConfig = {
    desktop: {
        label: "Desktop",
        color: "hsl(var(--chart-1))",
    },
    mobile: {
        label: "Mobile",
        color: "hsl(var(--chart-2))",
    },
} satisfies ChartConfig;

export function GraphOnuDBM() {
    return (
        <Card className="w-full mx-auto">
            <CardHeader>
                <CardTitle>Histórico e DBM</CardTitle>
                <CardDescription>
                    Cliente ONU Nome: CX01H-18553-Maria_Lucia_Ferrari
                </CardDescription>
            </CardHeader>
            <CardContent className="h-[15rem] sm:h-[20rem]">
                <ChartContainer config={chartConfig} className="w-full h-full">
                    <ResponsiveContainer width="100%" height="100%">
                        <AreaChart
                            accessibilityLayer
                            data={collections}
                            margin={{
                                left: 12,
                                right: 12,
                            }}
                        >
                            <CartesianGrid vertical={false} />
                            <XAxis
                                dataKey="COLLECTION_DATE"
                                tickLine={false}
                                axisLine={false}
                                tickMargin={8}
                                tickFormatter={(value) => value.slice(0, 3)}
                            />
                            <ChartTooltip
                                cursor={false}
                                content={
                                    <ChartTooltipContent indicator="line" />
                                }
                            />
                            <Area
                                dataKey="RXDBM"
                                type="natural"
                                fill="var(--color-mobile)"
                                fillOpacity={0.4}
                                stroke="var(--color-mobile)"
                                stackId="a"
                            />
                            <Area
                                dataKey="TXDBM"
                                type="natural"
                                fill="var(--color-desktop)"
                                fillOpacity={0.4}
                                stroke="var(--color-desktop)"
                                stackId="a"
                            />
                            <ChartLegend content={<ChartLegendContent />} />
                        </AreaChart>
                    </ResponsiveContainer>
                </ChartContainer>
            </CardContent>
        </Card>
    );
}
