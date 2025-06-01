import { describe, expect, test } from "vitest";
import { NullConnector } from "../src/connector";
import Echo from "../src/echo";

describe("Echo", () => {
    test("it will not throw error for supported driver", () => {
        expect(() => new Echo({ broadcaster: "reverb" })).not.toThrow(
            "Broadcaster string reverb is not supported.",
        );

        expect(() => new Echo({ broadcaster: "pusher" })).not.toThrow(
            "Broadcaster string pusher is not supported.",
        );

        expect(() => new Echo({ broadcaster: "socket.io" })).not.toThrow(
            "Broadcaster string socket.io is not supported.",
        );

        expect(() => new Echo({ broadcaster: "null" })).not.toThrow(
            "Broadcaster string null is not supported.",
        );
        expect(() => new Echo({ broadcaster: NullConnector })).not.toThrow();

        // eslint-disable-next-line
        // @ts-ignore
        // eslint-disable-next-line @typescript-eslint/no-empty-function
        expect(() => new Echo({ broadcaster: () => {} })).not.toThrow(
            "Broadcaster function is not supported.",
        );
    });

    test("it will throw error for unsupported driver", () => {
        // eslint-disable-next-line
        // @ts-ignore
        expect(() => new Echo({ broadcaster: "foo" })).toThrow(
            "Broadcaster string foo is not supported.",
        );
    });
});
